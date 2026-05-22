"use client";

import { Coins, Wallet, Clock, Users } from "lucide-react";
import { useAuth } from "@/context/AuthContext";

interface StatCardProps {
  title: string;
  value: string | number;
  subtitle: string;
  icon: React.ReactNode;
  color: "primary" | "secondary" | "success" | "warning";
}

function StatCard({ title, value, subtitle, icon, color }: StatCardProps) {
  const colorClasses = {
    primary: "bg-primary/10 text-primary",
    secondary: "bg-secondary/10 text-secondary",
    success: "bg-success/10 text-success",
    warning: "bg-warning/10 text-warning",
  };

  return (
    <div className="bg-card border border-border rounded-2xl p-6 card-hover">
      <div className="flex items-start justify-between">
        <div>
          <p className="text-muted-foreground text-sm mb-1">{title}</p>
          <p className="text-3xl font-bold text-foreground">{value}</p>
          <p className="text-muted-foreground text-xs mt-1">{subtitle}</p>
        </div>
        <div className={`p-3 rounded-xl ${colorClasses[color]}`}>{icon}</div>
      </div>
    </div>
  );
}

export function StatsGrid() {
  const { profile } = useAuth();

  const formatNumber = (num: number) => {
    return new Intl.NumberFormat("ar-EG").format(num);
  };

  const formatCurrency = (num: number) => {
    return new Intl.NumberFormat("ar-EG", {
      style: "currency",
      currency: "USD",
      minimumFractionDigits: 2,
    }).format(num);
  };

  return (
    <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
      <StatCard
        title="إجمالي النقاط"
        value={formatNumber(profile?.points || 0)}
        subtitle="نقطة متاحة للسحب"
        icon={<Coins className="w-6 h-6" />}
        color="primary"
      />
      <StatCard
        title="الرصيد المكتسب"
        value={formatCurrency(profile?.balance || 0)}
        subtitle="إجمالي الأرباح"
        icon={<Wallet className="w-6 h-6" />}
        color="success"
      />
      <StatCard
        title="السحب المعلق"
        value={formatCurrency(profile?.pendingCashout || 0)}
        subtitle="في انتظار المعالجة"
        icon={<Clock className="w-6 h-6" />}
        color="warning"
      />
      <StatCard
        title="الإحالات"
        value={formatNumber(profile?.referrals || 0)}
        subtitle="مستخدم تم دعوته"
        icon={<Users className="w-6 h-6" />}
        color="secondary"
      />
    </div>
  );
}
