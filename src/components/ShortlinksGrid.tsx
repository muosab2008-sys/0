"use client";

import { useState } from "react";
import { Link2, Coins, Clock, ArrowLeft } from "lucide-react";

interface ShortlinkProps {
  id: string;
  name: string;
  reward: number;
  dailyLimit: number;
  completedToday: number;
  cooldown?: number;
}

const shortlinks: ShortlinkProps[] = [
  {
    id: "sl1",
    name: "ShortLink Pro",
    reward: 5,
    dailyLimit: 10,
    completedToday: 3,
  },
  {
    id: "sl2",
    name: "LinkShrink",
    reward: 3,
    dailyLimit: 15,
    completedToday: 7,
  },
  {
    id: "sl3",
    name: "CutURL",
    reward: 4,
    dailyLimit: 12,
    completedToday: 5,
  },
  {
    id: "sl4",
    name: "MiniLink",
    reward: 2,
    dailyLimit: 20,
    completedToday: 12,
  },
  {
    id: "sl5",
    name: "FastShort",
    reward: 6,
    dailyLimit: 8,
    completedToday: 2,
  },
  {
    id: "sl6",
    name: "LinkGold",
    reward: 8,
    dailyLimit: 5,
    completedToday: 1,
  },
];

function ShortlinkCard({
  id,
  name,
  reward,
  dailyLimit,
  completedToday,
  cooldown,
}: ShortlinkProps) {
  const remaining = dailyLimit - completedToday;
  const progress = (completedToday / dailyLimit) * 100;
  const isLimitReached = remaining <= 0;

  return (
    <div
      className={`bg-card border border-border rounded-2xl p-5 card-hover ${
        isLimitReached ? "opacity-60" : ""
      }`}
    >
      <div className="flex items-start justify-between mb-3">
        <div className="flex items-center gap-3">
          <div className="w-10 h-10 bg-primary/10 rounded-xl flex items-center justify-center">
            <Link2 className="w-5 h-5 text-primary" />
          </div>
          <div>
            <h3 className="font-semibold text-foreground">{name}</h3>
            <p className="text-xs text-muted-foreground">
              {remaining} / {dailyLimit} متبقي
            </p>
          </div>
        </div>
        <div className="flex items-center gap-1 bg-primary/10 px-2 py-1 rounded-full">
          <Coins className="w-4 h-4 text-primary" />
          <span className="text-primary font-semibold text-sm">{reward}</span>
        </div>
      </div>

      {/* Progress Bar */}
      <div className="w-full h-1.5 bg-muted rounded-full mb-4 overflow-hidden">
        <div
          className="h-full bg-primary rounded-full transition-all duration-300"
          style={{ width: `${progress}%` }}
        />
      </div>

      {cooldown ? (
        <button
          disabled
          className="w-full flex items-center justify-center gap-2 bg-muted text-muted-foreground px-4 py-2.5 rounded-xl font-medium cursor-not-allowed"
        >
          <Clock className="w-4 h-4" />
          انتظر {cooldown} ثانية
        </button>
      ) : isLimitReached ? (
        <button
          disabled
          className="w-full flex items-center justify-center gap-2 bg-muted text-muted-foreground px-4 py-2.5 rounded-xl font-medium cursor-not-allowed"
        >
          تم الوصول للحد اليومي
        </button>
      ) : (
        <a
          href={`/sl/${id}`}
          className="w-full flex items-center justify-center gap-2 bg-primary hover:bg-primary-hover text-primary-foreground px-4 py-2.5 rounded-xl font-medium transition-colors"
        >
          ابدأ الكسب
          <ArrowLeft className="w-4 h-4" />
        </a>
      )}
    </div>
  );
}

export function ShortlinksGrid() {
  return (
    <section className="space-y-4">
      <div className="flex items-center justify-between">
        <div>
          <h2 className="text-2xl font-bold text-foreground">الروابط القصيرة</h2>
          <p className="text-muted-foreground">اختصر الروابط واكسب النقاط</p>
        </div>
        <a
          href="/shortlinks"
          className="text-primary hover:text-primary-hover font-medium text-sm transition-colors"
        >
          عرض الكل
        </a>
      </div>

      <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        {shortlinks.map((link) => (
          <ShortlinkCard key={link.id} {...link} />
        ))}
      </div>
    </section>
  );
}
