import { NextRequest, NextResponse } from "next/server";
import { adminDb } from "@/lib/firebase-admin";
import { FieldValue } from "firebase-admin/firestore";

// Secure secret token for postback verification
const POSTBACK_SECRET = process.env.POSTBACK_SECRET || "mrcash_secure_secret_key_2024";

export async function GET(request: NextRequest) {
  try {
    const { searchParams } = new URL(request.url);
    
    // Get parameters from the postback URL
    const userId = searchParams.get("user_id");
    const reward = searchParams.get("reward");
    const secret = searchParams.get("secret");
    const offerId = searchParams.get("offer_id");
    const offerName = searchParams.get("offer_name");
    const network = searchParams.get("network") || "shortlink";
    
    // Validate required parameters
    if (!userId || !reward || !secret) {
      return NextResponse.json(
        { success: false, error: "Missing required parameters" },
        { status: 400 }
      );
    }
    
    // Verify secret token
    if (secret !== POSTBACK_SECRET) {
      return NextResponse.json(
        { success: false, error: "Invalid secret token" },
        { status: 403 }
      );
    }
    
    // Parse and validate reward value
    const rewardValue = parseFloat(reward);
    if (isNaN(rewardValue) || rewardValue <= 0) {
      return NextResponse.json(
        { success: false, error: "Invalid reward value" },
        { status: 400 }
      );
    }
    
    // Get user document reference
    const userRef = adminDb.collection("users").doc(userId);
    const userDoc = await userRef.get();
    
    if (!userDoc.exists) {
      return NextResponse.json(
        { success: false, error: "User not found" },
        { status: 404 }
      );
    }
    
    // Update user's points using atomic increment
    await userRef.update({
      points: FieldValue.increment(rewardValue),
      balance: FieldValue.increment(rewardValue / 1000), // Convert points to USD (1000 points = $1)
      totalEarnings: FieldValue.increment(rewardValue / 1000),
    });
    
    // Log the transaction
    await adminDb.collection("transactions").add({
      userId,
      type: "credit",
      amount: rewardValue,
      network,
      offerId: offerId || null,
      offerName: offerName || "Shortlink Reward",
      status: "completed",
      createdAt: FieldValue.serverTimestamp(),
    });
    
    return NextResponse.json({
      success: true,
      message: "Reward credited successfully",
      userId,
      reward: rewardValue,
    });
    
  } catch (error) {
    console.error("Postback error:", error);
    return NextResponse.json(
      { success: false, error: "Internal server error" },
      { status: 500 }
    );
  }
}

// Also support POST requests for more secure postbacks
export async function POST(request: NextRequest) {
  try {
    const body = await request.json();
    
    const { userId, reward, secret, offerId, offerName, network } = body;
    
    // Validate required parameters
    if (!userId || !reward || !secret) {
      return NextResponse.json(
        { success: false, error: "Missing required parameters" },
        { status: 400 }
      );
    }
    
    // Verify secret token
    if (secret !== POSTBACK_SECRET) {
      return NextResponse.json(
        { success: false, error: "Invalid secret token" },
        { status: 403 }
      );
    }
    
    // Parse and validate reward value
    const rewardValue = parseFloat(reward);
    if (isNaN(rewardValue) || rewardValue <= 0) {
      return NextResponse.json(
        { success: false, error: "Invalid reward value" },
        { status: 400 }
      );
    }
    
    // Get user document reference
    const userRef = adminDb.collection("users").doc(userId);
    const userDoc = await userRef.get();
    
    if (!userDoc.exists) {
      return NextResponse.json(
        { success: false, error: "User not found" },
        { status: 404 }
      );
    }
    
    // Update user's points using atomic increment
    await userRef.update({
      points: FieldValue.increment(rewardValue),
      balance: FieldValue.increment(rewardValue / 1000),
      totalEarnings: FieldValue.increment(rewardValue / 1000),
    });
    
    // Log the transaction
    await adminDb.collection("transactions").add({
      userId,
      type: "credit",
      amount: rewardValue,
      network: network || "api",
      offerId: offerId || null,
      offerName: offerName || "API Reward",
      status: "completed",
      createdAt: FieldValue.serverTimestamp(),
    });
    
    return NextResponse.json({
      success: true,
      message: "Reward credited successfully",
      userId,
      reward: rewardValue,
    });
    
  } catch (error) {
    console.error("Postback error:", error);
    return NextResponse.json(
      { success: false, error: "Internal server error" },
      { status: 500 }
    );
  }
}
