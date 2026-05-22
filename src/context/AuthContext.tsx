"use client";

import React, { createContext, useContext, useEffect, useState } from "react";
import { User, onAuthStateChanged, signOut as firebaseSignOut } from "firebase/auth";
import { doc, onSnapshot } from "firebase/firestore";
import { auth, db } from "@/lib/firebase";

export interface UserProfile {
  uid: string;
  displayName: string;
  email: string;
  points: number;
  balance: number;
  role: "user" | "admin";
  pendingCashout?: number;
  totalEarnings?: number;
  referrals?: number;
  createdAt?: Date;
}

interface AuthContextType {
  user: User | null;
  profile: UserProfile | null;
  loading: boolean;
  signOut: () => Promise<void>;
}

const AuthContext = createContext<AuthContextType>({
  user: null,
  profile: null,
  loading: true,
  signOut: async () => {},
});

export function AuthProvider({ children }: { children: React.ReactNode }) {
  const [user, setUser] = useState<User | null>(null);
  const [profile, setProfile] = useState<UserProfile | null>(null);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    const unsubscribeAuth = onAuthStateChanged(auth, (firebaseUser) => {
      setUser(firebaseUser);
      
      if (!firebaseUser) {
        setProfile(null);
        setLoading(false);
        return;
      }

      // Subscribe to user document for real-time updates
      const userDocRef = doc(db, "users", firebaseUser.uid);
      const unsubscribeProfile = onSnapshot(
        userDocRef,
        (snapshot) => {
          if (snapshot.exists()) {
            const data = snapshot.data();
            setProfile({
              uid: firebaseUser.uid,
              displayName: data.displayName || firebaseUser.displayName || "User",
              email: data.email || firebaseUser.email || "",
              points: data.points || 0,
              balance: data.balance || 0,
              role: data.role || "user",
              pendingCashout: data.pendingCashout || 0,
              totalEarnings: data.totalEarnings || 0,
              referrals: data.referrals || 0,
              createdAt: data.createdAt?.toDate?.() || new Date(),
            });
          } else {
            // User document doesn't exist yet - create default profile
            setProfile({
              uid: firebaseUser.uid,
              displayName: firebaseUser.displayName || "User",
              email: firebaseUser.email || "",
              points: 0,
              balance: 0,
              role: "user",
              pendingCashout: 0,
              totalEarnings: 0,
              referrals: 0,
            });
          }
          setLoading(false);
        },
        (error) => {
          console.error("Error fetching user profile:", error);
          setLoading(false);
        }
      );

      return () => unsubscribeProfile();
    });

    return () => unsubscribeAuth();
  }, []);

  const signOut = async () => {
    try {
      await firebaseSignOut(auth);
      setUser(null);
      setProfile(null);
    } catch (error) {
      console.error("Error signing out:", error);
    }
  };

  return (
    <AuthContext.Provider value={{ user, profile, loading, signOut }}>
      {children}
    </AuthContext.Provider>
  );
}

export function useAuth() {
  const context = useContext(AuthContext);
  if (!context) {
    throw new Error("useAuth must be used within an AuthProvider");
  }
  return context;
}
