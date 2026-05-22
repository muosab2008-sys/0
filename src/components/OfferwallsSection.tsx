"use client";

import Image from "next/image";
import { ExternalLink, Star } from "lucide-react";

interface OfferwallCardProps {
  name: string;
  description: string;
  image: string;
  url: string;
  bonus?: string;
  rating?: number;
}

const offerwalls: OfferwallCardProps[] = [
  {
    name: "CPX Research",
    description: "أكمل الاستطلاعات واكسب نقاط فورية",
    image: "/offerwalls/cpx.png",
    url: "#cpx",
    bonus: "+20%",
    rating: 4.8,
  },
  {
    name: "TimeWall",
    description: "شاهد الفيديوهات وتفاعل مع التطبيقات",
    image: "/offerwalls/timewall.png",
    url: "#timewall",
    bonus: "+15%",
    rating: 4.6,
  },
  {
    name: "Wannads",
    description: "عروض حصرية بمكافآت عالية",
    image: "/offerwalls/wannads.png",
    url: "#wannads",
    rating: 4.5,
  },
  {
    name: "Lootably",
    description: "تثبيت التطبيقات والألعاب",
    image: "/offerwalls/lootably.png",
    url: "#lootably",
    bonus: "+10%",
    rating: 4.4,
  },
  {
    name: "AdGate Media",
    description: "مجموعة متنوعة من العروض",
    image: "/offerwalls/adgatemedia.png",
    url: "#adgate",
    rating: 4.3,
  },
  {
    name: "OfferToro",
    description: "عروض عالمية مميزة",
    image: "/offerwalls/offertoro.png",
    url: "#offertoro",
    rating: 4.2,
  },
];

function OfferwallCard({
  name,
  description,
  image,
  url,
  bonus,
  rating,
}: OfferwallCardProps) {
  return (
    <a
      href={url}
      target="_blank"
      rel="noopener noreferrer"
      className="group bg-card border border-border rounded-2xl p-5 card-hover flex flex-col"
    >
      <div className="flex items-start justify-between mb-4">
        <div className="w-14 h-14 bg-muted rounded-xl overflow-hidden flex items-center justify-center">
          <div className="w-10 h-10 bg-primary/20 rounded-lg flex items-center justify-center text-primary font-bold text-lg">
            {name.charAt(0)}
          </div>
        </div>
        {bonus && (
          <span className="bg-success/10 text-success text-xs font-semibold px-2 py-1 rounded-full">
            {bonus}
          </span>
        )}
      </div>

      <h3 className="text-lg font-semibold text-foreground mb-1">{name}</h3>
      <p className="text-muted-foreground text-sm mb-4 flex-grow">
        {description}
      </p>

      <div className="flex items-center justify-between">
        {rating && (
          <div className="flex items-center gap-1">
            <Star className="w-4 h-4 text-primary fill-primary" />
            <span className="text-sm text-foreground">{rating}</span>
          </div>
        )}
        <div className="flex items-center gap-1 text-primary text-sm font-medium group-hover:gap-2 transition-all">
          ابدأ الآن
          <ExternalLink className="w-4 h-4" />
        </div>
      </div>
    </a>
  );
}

export function OfferwallsSection() {
  return (
    <section className="space-y-4">
      <div className="flex items-center justify-between">
        <div>
          <h2 className="text-2xl font-bold text-foreground">جدران العروض</h2>
          <p className="text-muted-foreground">أكمل العروض واكسب النقاط</p>
        </div>
        <a
          href="/offers"
          className="text-primary hover:text-primary-hover font-medium text-sm transition-colors"
        >
          عرض الكل
        </a>
      </div>

      <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        {offerwalls.map((wall) => (
          <OfferwallCard key={wall.name} {...wall} />
        ))}
      </div>
    </section>
  );
}
