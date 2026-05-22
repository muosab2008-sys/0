"use client";

import { useState } from "react";
import Link from "next/link";
import Image from "next/image";
import { useAuth } from "@/context/AuthContext";
import {
  Coins,
  User,
  LogOut,
  Settings,
  ChevronDown,
  Menu,
  X,
  Shield,
  History,
  Wallet,
} from "lucide-react";

export function Navbar() {
  const { user, profile, loading, signOut } = useAuth();
  const [isProfileOpen, setIsProfileOpen] = useState(false);
  const [isMobileMenuOpen, setIsMobileMenuOpen] = useState(false);

  const formatNumber = (num: number) => {
    return new Intl.NumberFormat("ar-EG").format(num);
  };

  return (
    <nav className="sticky top-0 z-50 glass border-b border-border">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div className="flex items-center justify-between h-16">
          {/* Logo */}
          <Link href="/" className="flex items-center gap-3">
            <div className="relative w-10 h-10 bg-primary/20 rounded-xl flex items-center justify-center">
              <Coins className="w-6 h-6 text-primary" />
            </div>
            <span className="text-xl font-bold text-foreground">MrCash</span>
          </Link>

          {/* Desktop Navigation */}
          <div className="hidden md:flex items-center gap-6">
            <Link
              href="/"
              className="text-muted-foreground hover:text-foreground transition-colors"
            >
              الرئيسية
            </Link>
            <Link
              href="/offers"
              className="text-muted-foreground hover:text-foreground transition-colors"
            >
              العروض
            </Link>
            <Link
              href="/shortlinks"
              className="text-muted-foreground hover:text-foreground transition-colors"
            >
              الروابط
            </Link>
            <Link
              href="/withdraw"
              className="text-muted-foreground hover:text-foreground transition-colors"
            >
              السحب
            </Link>
          </div>

          {/* User Section */}
          <div className="flex items-center gap-4">
            {/* Points Display */}
            {user && profile && (
              <div className="hidden sm:flex items-center gap-2 bg-card px-4 py-2 rounded-xl border border-border">
                <div className="coin-animation">
                  <Coins className="w-5 h-5 text-primary" />
                </div>
                <span className="font-semibold text-foreground">
                  {formatNumber(profile.points)}
                </span>
                <span className="text-muted-foreground text-sm">نقطة</span>
              </div>
            )}

            {/* Profile Dropdown */}
            {user && profile ? (
              <div className="relative">
                <button
                  onClick={() => setIsProfileOpen(!isProfileOpen)}
                  className="flex items-center gap-2 bg-card hover:bg-card-hover px-3 py-2 rounded-xl border border-border transition-colors"
                >
                  <div className="w-8 h-8 bg-primary/20 rounded-full flex items-center justify-center">
                    <User className="w-4 h-4 text-primary" />
                  </div>
                  <span className="hidden sm:block text-sm font-medium text-foreground">
                    {profile.displayName}
                  </span>
                  <ChevronDown
                    className={`w-4 h-4 text-muted-foreground transition-transform ${
                      isProfileOpen ? "rotate-180" : ""
                    }`}
                  />
                </button>

                {isProfileOpen && (
                  <div className="absolute left-0 mt-2 w-56 bg-card border border-border rounded-xl shadow-lg py-2 z-50">
                    <div className="px-4 py-3 border-b border-border">
                      <p className="text-sm font-medium text-foreground">
                        {profile.displayName}
                      </p>
                      <p className="text-xs text-muted-foreground">
                        {profile.email}
                      </p>
                    </div>

                    {/* Mobile Points Display */}
                    <div className="sm:hidden px-4 py-3 border-b border-border">
                      <div className="flex items-center gap-2">
                        <Coins className="w-4 h-4 text-primary" />
                        <span className="font-semibold">
                          {formatNumber(profile.points)}
                        </span>
                        <span className="text-muted-foreground text-sm">
                          نقطة
                        </span>
                      </div>
                    </div>

                    <Link
                      href="/account"
                      className="flex items-center gap-3 px-4 py-2 text-sm text-foreground hover:bg-muted transition-colors"
                      onClick={() => setIsProfileOpen(false)}
                    >
                      <Settings className="w-4 h-4" />
                      الإعدادات
                    </Link>
                    <Link
                      href="/history"
                      className="flex items-center gap-3 px-4 py-2 text-sm text-foreground hover:bg-muted transition-colors"
                      onClick={() => setIsProfileOpen(false)}
                    >
                      <History className="w-4 h-4" />
                      السجل
                    </Link>
                    <Link
                      href="/withdraw"
                      className="flex items-center gap-3 px-4 py-2 text-sm text-foreground hover:bg-muted transition-colors"
                      onClick={() => setIsProfileOpen(false)}
                    >
                      <Wallet className="w-4 h-4" />
                      السحب
                    </Link>

                    {profile.role === "admin" && (
                      <Link
                        href="/admin"
                        className="flex items-center gap-3 px-4 py-2 text-sm text-primary hover:bg-muted transition-colors"
                        onClick={() => setIsProfileOpen(false)}
                      >
                        <Shield className="w-4 h-4" />
                        لوحة التحكم
                      </Link>
                    )}

                    <div className="border-t border-border mt-2 pt-2">
                      <button
                        onClick={() => {
                          signOut();
                          setIsProfileOpen(false);
                        }}
                        className="flex items-center gap-3 w-full px-4 py-2 text-sm text-error hover:bg-muted transition-colors"
                      >
                        <LogOut className="w-4 h-4" />
                        تسجيل الخروج
                      </button>
                    </div>
                  </div>
                )}
              </div>
            ) : (
              !loading && (
                <Link
                  href="/login"
                  className="bg-primary hover:bg-primary-hover text-primary-foreground px-4 py-2 rounded-xl font-medium transition-colors"
                >
                  تسجيل الدخول
                </Link>
              )
            )}

            {/* Mobile Menu Toggle */}
            <button
              onClick={() => setIsMobileMenuOpen(!isMobileMenuOpen)}
              className="md:hidden p-2 text-foreground"
            >
              {isMobileMenuOpen ? (
                <X className="w-6 h-6" />
              ) : (
                <Menu className="w-6 h-6" />
              )}
            </button>
          </div>
        </div>

        {/* Mobile Navigation */}
        {isMobileMenuOpen && (
          <div className="md:hidden border-t border-border py-4 space-y-2">
            <Link
              href="/"
              className="block px-4 py-2 text-foreground hover:bg-muted rounded-lg transition-colors"
              onClick={() => setIsMobileMenuOpen(false)}
            >
              الرئيسية
            </Link>
            <Link
              href="/offers"
              className="block px-4 py-2 text-foreground hover:bg-muted rounded-lg transition-colors"
              onClick={() => setIsMobileMenuOpen(false)}
            >
              العروض
            </Link>
            <Link
              href="/shortlinks"
              className="block px-4 py-2 text-foreground hover:bg-muted rounded-lg transition-colors"
              onClick={() => setIsMobileMenuOpen(false)}
            >
              الروابط
            </Link>
            <Link
              href="/withdraw"
              className="block px-4 py-2 text-foreground hover:bg-muted rounded-lg transition-colors"
              onClick={() => setIsMobileMenuOpen(false)}
            >
              السحب
            </Link>
          </div>
        )}
      </div>
    </nav>
  );
}
