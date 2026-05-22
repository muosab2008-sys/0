"use client";

import { useEffect, useState } from "react";
import { useRouter } from "next/navigation";
import { useAuth } from "@/context/AuthContext";
import { collection, query, orderBy, limit, onSnapshot, doc, updateDoc, deleteDoc } from "firebase/firestore";
import { db } from "@/lib/firebase";
import {
  Users,
  Coins,
  Wallet,
  TrendingUp,
  Clock,
  CheckCircle,
  XCircle,
  Search,
  ArrowRight,
  Shield,
  Loader2,
  RefreshCw,
} from "lucide-react";
import Link from "next/link";

interface UserData {
  id: string;
  displayName: string;
  email: string;
  points: number;
  balance: number;
  role: string;
  createdAt: Date;
}

interface WithdrawalData {
  id: string;
  userId: string;
  userEmail: string;
  amount: number;
  method: string;
  accountInfo: string;
  status: "pending" | "approved" | "rejected";
  createdAt: Date;
}

interface PlatformStats {
  totalUsers: number;
  totalPoints: number;
  totalWithdrawals: number;
  pendingWithdrawals: number;
}

function StatCard({
  title,
  value,
  icon,
  color,
}: {
  title: string;
  value: string | number;
  icon: React.ReactNode;
  color: string;
}) {
  return (
    <div className="bg-card border border-border rounded-2xl p-6">
      <div className="flex items-start justify-between">
        <div>
          <p className="text-muted-foreground text-sm mb-1">{title}</p>
          <p className="text-3xl font-bold text-foreground">{value}</p>
        </div>
        <div className={`p-3 rounded-xl ${color}`}>{icon}</div>
      </div>
    </div>
  );
}

export default function AdminPage() {
  const { user, profile, loading } = useAuth();
  const router = useRouter();
  const [users, setUsers] = useState<UserData[]>([]);
  const [withdrawals, setWithdrawals] = useState<WithdrawalData[]>([]);
  const [stats, setStats] = useState<PlatformStats>({
    totalUsers: 0,
    totalPoints: 0,
    totalWithdrawals: 0,
    pendingWithdrawals: 0,
  });
  const [searchTerm, setSearchTerm] = useState("");
  const [processingId, setProcessingId] = useState<string | null>(null);
  const [activeTab, setActiveTab] = useState<"users" | "withdrawals">("users");

  useEffect(() => {
    if (!loading && (!user || profile?.role !== "admin")) {
      router.push("/");
      return;
    }

    if (profile?.role === "admin") {
      // Subscribe to users collection
      const usersQuery = query(
        collection(db, "users"),
        orderBy("createdAt", "desc"),
        limit(100)
      );

      const unsubscribeUsers = onSnapshot(usersQuery, (snapshot) => {
        const usersData: UserData[] = [];
        let totalPoints = 0;

        snapshot.forEach((doc) => {
          const data = doc.data();
          usersData.push({
            id: doc.id,
            displayName: data.displayName || "Unknown",
            email: data.email || "",
            points: data.points || 0,
            balance: data.balance || 0,
            role: data.role || "user",
            createdAt: data.createdAt?.toDate?.() || new Date(),
          });
          totalPoints += data.points || 0;
        });

        setUsers(usersData);
        setStats((prev) => ({
          ...prev,
          totalUsers: usersData.length,
          totalPoints,
        }));
      });

      // Subscribe to withdrawals collection
      const withdrawalsQuery = query(
        collection(db, "withdrawals"),
        orderBy("createdAt", "desc"),
        limit(50)
      );

      const unsubscribeWithdrawals = onSnapshot(withdrawalsQuery, (snapshot) => {
        const withdrawalsData: WithdrawalData[] = [];
        let pendingCount = 0;

        snapshot.forEach((doc) => {
          const data = doc.data();
          withdrawalsData.push({
            id: doc.id,
            userId: data.userId,
            userEmail: data.userEmail || "",
            amount: data.amount || 0,
            method: data.method || "Unknown",
            accountInfo: data.accountInfo || "",
            status: data.status || "pending",
            createdAt: data.createdAt?.toDate?.() || new Date(),
          });
          if (data.status === "pending") pendingCount++;
        });

        setWithdrawals(withdrawalsData);
        setStats((prev) => ({
          ...prev,
          totalWithdrawals: withdrawalsData.length,
          pendingWithdrawals: pendingCount,
        }));
      });

      return () => {
        unsubscribeUsers();
        unsubscribeWithdrawals();
      };
    }
  }, [user, profile, loading, router]);

  const handleWithdrawalAction = async (
    withdrawalId: string,
    userId: string,
    amount: number,
    action: "approve" | "reject"
  ) => {
    setProcessingId(withdrawalId);

    try {
      const withdrawalRef = doc(db, "withdrawals", withdrawalId);
      await updateDoc(withdrawalRef, {
        status: action === "approve" ? "approved" : "rejected",
        processedAt: new Date(),
      });

      // If rejected, refund the points to the user
      if (action === "reject") {
        const userRef = doc(db, "users", userId);
        await updateDoc(userRef, {
          points: (users.find((u) => u.id === userId)?.points || 0) + amount * 1000,
          pendingCashout:
            (users.find((u) => u.id === userId)?.balance || 0) - amount,
        });
      }
    } catch (error) {
      console.error("Error processing withdrawal:", error);
    } finally {
      setProcessingId(null);
    }
  };

  const filteredUsers = users.filter(
    (u) =>
      u.displayName.toLowerCase().includes(searchTerm.toLowerCase()) ||
      u.email.toLowerCase().includes(searchTerm.toLowerCase())
  );

  const formatDate = (date: Date) => {
    return new Intl.DateTimeFormat("ar-EG", {
      year: "numeric",
      month: "short",
      day: "numeric",
      hour: "2-digit",
      minute: "2-digit",
    }).format(date);
  };

  const formatCurrency = (amount: number) => {
    return new Intl.NumberFormat("ar-EG", {
      style: "currency",
      currency: "USD",
    }).format(amount);
  };

  if (loading) {
    return (
      <div className="min-h-screen bg-background flex items-center justify-center">
        <Loader2 className="w-8 h-8 text-primary animate-spin" />
      </div>
    );
  }

  if (!user || profile?.role !== "admin") {
    return null;
  }

  return (
    <div className="min-h-screen bg-background">
      {/* Header */}
      <header className="border-b border-border bg-card">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
          <div className="flex items-center justify-between">
            <div className="flex items-center gap-3">
              <div className="p-2 bg-primary/20 rounded-xl">
                <Shield className="w-6 h-6 text-primary" />
              </div>
              <div>
                <h1 className="text-xl font-bold text-foreground">
                  لوحة التحكم
                </h1>
                <p className="text-sm text-muted-foreground">إدارة المنصة</p>
              </div>
            </div>
            <Link
              href="/"
              className="flex items-center gap-2 text-muted-foreground hover:text-foreground transition-colors"
            >
              العودة للرئيسية
              <ArrowRight className="w-4 h-4" />
            </Link>
          </div>
        </div>
      </header>

      <main className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">
        {/* Stats Grid */}
        <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
          <StatCard
            title="إجمالي المستخدمين"
            value={stats.totalUsers}
            icon={<Users className="w-6 h-6" />}
            color="bg-primary/10 text-primary"
          />
          <StatCard
            title="إجمالي النقاط"
            value={stats.totalPoints.toLocaleString("ar-EG")}
            icon={<Coins className="w-6 h-6" />}
            color="bg-warning/10 text-warning"
          />
          <StatCard
            title="طلبات السحب"
            value={stats.totalWithdrawals}
            icon={<Wallet className="w-6 h-6" />}
            color="bg-success/10 text-success"
          />
          <StatCard
            title="سحوبات معلقة"
            value={stats.pendingWithdrawals}
            icon={<Clock className="w-6 h-6" />}
            color="bg-secondary/10 text-secondary"
          />
        </div>

        {/* Tabs */}
        <div className="flex gap-2 border-b border-border">
          <button
            onClick={() => setActiveTab("users")}
            className={`px-4 py-2 font-medium transition-colors border-b-2 -mb-px ${
              activeTab === "users"
                ? "text-primary border-primary"
                : "text-muted-foreground border-transparent hover:text-foreground"
            }`}
          >
            المستخدمين
          </button>
          <button
            onClick={() => setActiveTab("withdrawals")}
            className={`px-4 py-2 font-medium transition-colors border-b-2 -mb-px ${
              activeTab === "withdrawals"
                ? "text-primary border-primary"
                : "text-muted-foreground border-transparent hover:text-foreground"
            }`}
          >
            طلبات السحب
            {stats.pendingWithdrawals > 0 && (
              <span className="mr-2 bg-error text-white text-xs px-2 py-0.5 rounded-full">
                {stats.pendingWithdrawals}
              </span>
            )}
          </button>
        </div>

        {/* Users Tab */}
        {activeTab === "users" && (
          <div className="space-y-4">
            {/* Search */}
            <div className="relative">
              <Search className="absolute right-3 top-1/2 -translate-y-1/2 w-5 h-5 text-muted-foreground" />
              <input
                type="text"
                placeholder="ابحث عن مستخدم..."
                value={searchTerm}
                onChange={(e) => setSearchTerm(e.target.value)}
                className="w-full bg-card border border-border rounded-xl px-4 py-3 pr-11 text-foreground placeholder:text-muted-foreground focus:outline-none focus:ring-2 focus:ring-primary"
              />
            </div>

            {/* Users Table */}
            <div className="bg-card border border-border rounded-2xl overflow-hidden">
              <div className="overflow-x-auto">
                <table className="w-full">
                  <thead>
                    <tr className="border-b border-border bg-muted/50">
                      <th className="text-right px-4 py-3 text-sm font-medium text-muted-foreground">
                        المستخدم
                      </th>
                      <th className="text-right px-4 py-3 text-sm font-medium text-muted-foreground">
                        النقاط
                      </th>
                      <th className="text-right px-4 py-3 text-sm font-medium text-muted-foreground">
                        الرصيد
                      </th>
                      <th className="text-right px-4 py-3 text-sm font-medium text-muted-foreground">
                        الدور
                      </th>
                      <th className="text-right px-4 py-3 text-sm font-medium text-muted-foreground">
                        تاريخ التسجيل
                      </th>
                    </tr>
                  </thead>
                  <tbody>
                    {filteredUsers.map((user) => (
                      <tr
                        key={user.id}
                        className="border-b border-border last:border-b-0 hover:bg-muted/30 transition-colors"
                      >
                        <td className="px-4 py-3">
                          <div>
                            <p className="font-medium text-foreground">
                              {user.displayName}
                            </p>
                            <p className="text-sm text-muted-foreground">
                              {user.email}
                            </p>
                          </div>
                        </td>
                        <td className="px-4 py-3">
                          <span className="font-medium text-foreground">
                            {user.points.toLocaleString("ar-EG")}
                          </span>
                        </td>
                        <td className="px-4 py-3">
                          <span className="text-foreground">
                            {formatCurrency(user.balance)}
                          </span>
                        </td>
                        <td className="px-4 py-3">
                          <span
                            className={`px-2 py-1 rounded-full text-xs font-medium ${
                              user.role === "admin"
                                ? "bg-primary/10 text-primary"
                                : "bg-muted text-muted-foreground"
                            }`}
                          >
                            {user.role === "admin" ? "مدير" : "مستخدم"}
                          </span>
                        </td>
                        <td className="px-4 py-3 text-sm text-muted-foreground">
                          {formatDate(user.createdAt)}
                        </td>
                      </tr>
                    ))}
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        )}

        {/* Withdrawals Tab */}
        {activeTab === "withdrawals" && (
          <div className="bg-card border border-border rounded-2xl overflow-hidden">
            <div className="overflow-x-auto">
              <table className="w-full">
                <thead>
                  <tr className="border-b border-border bg-muted/50">
                    <th className="text-right px-4 py-3 text-sm font-medium text-muted-foreground">
                      المستخدم
                    </th>
                    <th className="text-right px-4 py-3 text-sm font-medium text-muted-foreground">
                      المبلغ
                    </th>
                    <th className="text-right px-4 py-3 text-sm font-medium text-muted-foreground">
                      طريقة الدفع
                    </th>
                    <th className="text-right px-4 py-3 text-sm font-medium text-muted-foreground">
                      الحالة
                    </th>
                    <th className="text-right px-4 py-3 text-sm font-medium text-muted-foreground">
                      التاريخ
                    </th>
                    <th className="text-right px-4 py-3 text-sm font-medium text-muted-foreground">
                      الإجراءات
                    </th>
                  </tr>
                </thead>
                <tbody>
                  {withdrawals.length === 0 ? (
                    <tr>
                      <td
                        colSpan={6}
                        className="px-4 py-8 text-center text-muted-foreground"
                      >
                        لا توجد طلبات سحب حالياً
                      </td>
                    </tr>
                  ) : (
                    withdrawals.map((withdrawal) => (
                      <tr
                        key={withdrawal.id}
                        className="border-b border-border last:border-b-0 hover:bg-muted/30 transition-colors"
                      >
                        <td className="px-4 py-3">
                          <p className="text-sm text-muted-foreground">
                            {withdrawal.userEmail}
                          </p>
                        </td>
                        <td className="px-4 py-3">
                          <span className="font-medium text-foreground">
                            {formatCurrency(withdrawal.amount)}
                          </span>
                        </td>
                        <td className="px-4 py-3">
                          <div>
                            <p className="text-foreground">{withdrawal.method}</p>
                            <p className="text-xs text-muted-foreground">
                              {withdrawal.accountInfo}
                            </p>
                          </div>
                        </td>
                        <td className="px-4 py-3">
                          <span
                            className={`px-2 py-1 rounded-full text-xs font-medium ${
                              withdrawal.status === "pending"
                                ? "bg-warning/10 text-warning"
                                : withdrawal.status === "approved"
                                ? "bg-success/10 text-success"
                                : "bg-error/10 text-error"
                            }`}
                          >
                            {withdrawal.status === "pending"
                              ? "معلق"
                              : withdrawal.status === "approved"
                              ? "مقبول"
                              : "مرفوض"}
                          </span>
                        </td>
                        <td className="px-4 py-3 text-sm text-muted-foreground">
                          {formatDate(withdrawal.createdAt)}
                        </td>
                        <td className="px-4 py-3">
                          {withdrawal.status === "pending" && (
                            <div className="flex items-center gap-2">
                              <button
                                onClick={() =>
                                  handleWithdrawalAction(
                                    withdrawal.id,
                                    withdrawal.userId,
                                    withdrawal.amount,
                                    "approve"
                                  )
                                }
                                disabled={processingId === withdrawal.id}
                                className="p-2 bg-success/10 text-success rounded-lg hover:bg-success/20 transition-colors disabled:opacity-50"
                              >
                                {processingId === withdrawal.id ? (
                                  <RefreshCw className="w-4 h-4 animate-spin" />
                                ) : (
                                  <CheckCircle className="w-4 h-4" />
                                )}
                              </button>
                              <button
                                onClick={() =>
                                  handleWithdrawalAction(
                                    withdrawal.id,
                                    withdrawal.userId,
                                    withdrawal.amount,
                                    "reject"
                                  )
                                }
                                disabled={processingId === withdrawal.id}
                                className="p-2 bg-error/10 text-error rounded-lg hover:bg-error/20 transition-colors disabled:opacity-50"
                              >
                                <XCircle className="w-4 h-4" />
                              </button>
                            </div>
                          )}
                        </td>
                      </tr>
                    ))
                  )}
                </tbody>
              </table>
            </div>
          </div>
        )}
      </main>
    </div>
  );
}
