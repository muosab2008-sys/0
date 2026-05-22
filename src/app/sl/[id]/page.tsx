"use client";

import { useEffect, useState } from "react";
import { useParams, useRouter } from "next/navigation";
import { useAuth } from "@/context/AuthContext";
import { Coins, Clock, CheckCircle, ExternalLink, Loader2 } from "lucide-react";

export default function ShortlinkPage() {
  const params = useParams();
  const router = useRouter();
  const { user, profile } = useAuth();
  const [countdown, setCountdown] = useState(10);
  const [isReady, setIsReady] = useState(false);
  const [isCompleted, setIsCompleted] = useState(false);
  const [externalUrl, setExternalUrl] = useState("");

  const shortlinkId = params.id as string;

  // Simulated shortlink data (in production, fetch from Firestore)
  const shortlinkData = {
    sl1: { name: "ShortLink Pro", reward: 5, url: "https://example.com/sl1" },
    sl2: { name: "LinkShrink", reward: 3, url: "https://example.com/sl2" },
    sl3: { name: "CutURL", reward: 4, url: "https://example.com/sl3" },
    sl4: { name: "MiniLink", reward: 2, url: "https://example.com/sl4" },
    sl5: { name: "FastShort", reward: 6, url: "https://example.com/sl5" },
    sl6: { name: "LinkGold", reward: 8, url: "https://example.com/sl6" },
  };

  const currentLink = shortlinkData[shortlinkId as keyof typeof shortlinkData];

  useEffect(() => {
    if (!user) {
      router.push("/");
      return;
    }

    if (!currentLink) {
      router.push("/shortlinks");
      return;
    }

    // Countdown timer
    const timer = setInterval(() => {
      setCountdown((prev) => {
        if (prev <= 1) {
          clearInterval(timer);
          setIsReady(true);
          return 0;
        }
        return prev - 1;
      });
    }, 1000);

    return () => clearInterval(timer);
  }, [user, router, currentLink]);

  const handleClaim = async () => {
    if (!isReady || !user || !currentLink) return;

    try {
      // In production, this would be handled by the external shortlink provider
      // The postback URL would be called when the user completes the shortlink
      setExternalUrl(currentLink.url);
      
      // Simulate reward claim (in production, this is done via postback)
      // For demo purposes, we'll call our API directly
      const response = await fetch("/api/postback", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({
          userId: user.uid,
          reward: currentLink.reward,
          secret: "mrcash_secure_secret_key_2024", // In production, this comes from the shortlink provider
          network: "shortlink",
          offerName: currentLink.name,
        }),
      });

      if (response.ok) {
        setIsCompleted(true);
      }
    } catch (error) {
      console.error("Error claiming reward:", error);
    }
  };

  if (!currentLink) {
    return (
      <div className="min-h-screen bg-background flex items-center justify-center">
        <Loader2 className="w-8 h-8 text-primary animate-spin" />
      </div>
    );
  }

  return (
    <div className="min-h-screen bg-background flex items-center justify-center p-4">
      <div className="w-full max-w-md">
        <div className="bg-card border border-border rounded-2xl p-8 text-center">
          {isCompleted ? (
            <>
              <div className="w-16 h-16 bg-success/20 rounded-full flex items-center justify-center mx-auto mb-4">
                <CheckCircle className="w-8 h-8 text-success" />
              </div>
              <h1 className="text-2xl font-bold text-foreground mb-2">
                تم الحصول على المكافأة!
              </h1>
              <p className="text-muted-foreground mb-6">
                تم إضافة {currentLink.reward} نقطة إلى حسابك
              </p>
              <button
                onClick={() => router.push("/")}
                className="w-full bg-primary hover:bg-primary-hover text-primary-foreground font-medium py-3 rounded-xl transition-colors"
              >
                العودة للرئيسية
              </button>
            </>
          ) : (
            <>
              <div className="w-16 h-16 bg-primary/20 rounded-full flex items-center justify-center mx-auto mb-4">
                <Coins className="w-8 h-8 text-primary coin-animation" />
              </div>
              
              <h1 className="text-2xl font-bold text-foreground mb-2">
                {currentLink.name}
              </h1>
              
              <p className="text-muted-foreground mb-6">
                أكمل الرابط للحصول على المكافأة
              </p>

              <div className="bg-muted rounded-xl p-4 mb-6">
                <div className="flex items-center justify-center gap-2">
                  <Coins className="w-5 h-5 text-primary" />
                  <span className="text-2xl font-bold text-foreground">
                    {currentLink.reward}
                  </span>
                  <span className="text-muted-foreground">نقطة</span>
                </div>
              </div>

              {!isReady ? (
                <div className="space-y-4">
                  <div className="flex items-center justify-center gap-2 text-muted-foreground">
                    <Clock className="w-5 h-5" />
                    <span>انتظر {countdown} ثانية</span>
                  </div>
                  <div className="w-full h-2 bg-muted rounded-full overflow-hidden">
                    <div
                      className="h-full bg-primary transition-all duration-1000"
                      style={{ width: `${((10 - countdown) / 10) * 100}%` }}
                    />
                  </div>
                </div>
              ) : (
                <button
                  onClick={handleClaim}
                  className="w-full flex items-center justify-center gap-2 bg-primary hover:bg-primary-hover text-primary-foreground font-medium py-3 rounded-xl transition-colors"
                >
                  احصل على المكافأة
                  <ExternalLink className="w-4 h-4" />
                </button>
              )}

              <p className="text-xs text-muted-foreground mt-4">
                بالنقر على الزر، ستتم إعادة توجيهك إلى صفحة خارجية
              </p>
            </>
          )}
        </div>
      </div>
    </div>
  );
}
