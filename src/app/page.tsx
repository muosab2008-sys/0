"use client";

import { useAuth } from "@/context/AuthContext";
import { Navbar } from "@/components/Navbar";
import { StatsGrid } from "@/components/StatsGrid";
import { OfferwallsSection } from "@/components/OfferwallsSection";
import { ShortlinksGrid } from "@/components/ShortlinksGrid";
import { LoginForm } from "@/components/LoginForm";
import { Coins, Zap, Shield, Trophy } from "lucide-react";

function LoadingSpinner() {
  return (
    <div className="min-h-screen flex items-center justify-center bg-background">
      <div className="text-center">
        <div className="coin-animation inline-block mb-4">
          <Coins className="w-12 h-12 text-primary" />
        </div>
        <p className="text-muted-foreground">جاري التحميل...</p>
      </div>
    </div>
  );
}

function HeroSection() {
  return (
    <section className="relative overflow-hidden bg-card border border-border rounded-3xl p-8 md:p-12">
      {/* Background decoration */}
      <div className="absolute inset-0 bg-gradient-to-br from-primary/5 via-transparent to-secondary/5 pointer-events-none" />
      
      <div className="relative z-10 max-w-2xl">
        <div className="inline-flex items-center gap-2 bg-primary/10 text-primary px-3 py-1 rounded-full text-sm font-medium mb-4">
          <Zap className="w-4 h-4" />
          مكافآت يومية
        </div>
        
        <h1 className="text-3xl md:text-4xl font-bold text-foreground mb-4 text-balance">
          مرحباً بك في MrCash
        </h1>
        
        <p className="text-muted-foreground text-lg mb-6 text-pretty">
          أكمل العروض والمهام واكسب نقاط حقيقية يمكنك تحويلها إلى أموال نقدية. انضم إلى آلاف المستخدمين الذين يكسبون يومياً!
        </p>
        
        <div className="flex flex-wrap gap-6">
          <div className="flex items-center gap-2">
            <Shield className="w-5 h-5 text-success" />
            <span className="text-foreground">دفع آمن</span>
          </div>
          <div className="flex items-center gap-2">
            <Trophy className="w-5 h-5 text-primary" />
            <span className="text-foreground">مكافآت فورية</span>
          </div>
          <div className="flex items-center gap-2">
            <Coins className="w-5 h-5 text-warning" />
            <span className="text-foreground">سحب سريع</span>
          </div>
        </div>
      </div>
    </section>
  );
}

function Dashboard() {
  return (
    <div className="min-h-screen bg-background">
      <Navbar />
      
      <main className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">
        {/* Welcome Section */}
        <HeroSection />

        {/* Stats */}
        <StatsGrid />

        {/* Offerwalls */}
        <OfferwallsSection />

        {/* Shortlinks */}
        <ShortlinksGrid />
      </main>

      {/* Footer */}
      <footer className="border-t border-border mt-12">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
          <div className="flex flex-col md:flex-row items-center justify-between gap-4">
            <div className="flex items-center gap-2">
              <Coins className="w-6 h-6 text-primary" />
              <span className="font-bold text-foreground">MrCash</span>
            </div>
            <p className="text-muted-foreground text-sm">
              © 2024 MrCash. جميع الحقوق محفوظة.
            </p>
            <div className="flex items-center gap-4">
              <a href="/tos" className="text-muted-foreground hover:text-foreground text-sm transition-colors">
                الشروط والأحكام
              </a>
              <a href="/privacy" className="text-muted-foreground hover:text-foreground text-sm transition-colors">
                سياسة الخصوصية
              </a>
              <a href="/contact" className="text-muted-foreground hover:text-foreground text-sm transition-colors">
                اتصل بنا
              </a>
            </div>
          </div>
        </div>
      </footer>
    </div>
  );
}

export default function Home() {
  const { user, loading } = useAuth();

  if (loading) {
    return <LoadingSpinner />;
  }

  if (!user) {
    return <LoginForm />;
  }

  return <Dashboard />;
}
