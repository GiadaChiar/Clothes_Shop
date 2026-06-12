

import { useEffect, useState } from "react";
import "../style/valutation.scss";

export default function ValutationCard({ data }) {

    const ai = data.ai;
    const tips = data.tips;

    console.log("sono in valuatatio card", ai)
    console.log("sono in valuatation tips", tips)
    const [show, setShow] = useState(false);

    useEffect(() => {
        if (ai) {
            setTimeout(() => setShow(true), 100);
        }
    }, [ai]);

    if (!ai) return null;

    const seasonIcon = {
        primavera: "🌸",
        estate: "☀️",
        autunno: "🍂",
        inverno: "❄️",
    };

    return (
        <div className={`card ${show ? "show" : ""}`}>

            {/* HEADER */}
            <div className="top">
                <h2>Valutazione AI</h2>
            </div>

            {/* PRICE HERO */}
            <div className="priceHero">
                <div className="price">€ {ai.suggested_price}</div>
                <div className="range">
                    €{ai.range_min} - €{ai.range_max}
                </div>
            </div>

            {/* TAGS */}
            <div className="tags">
                <span className={`tag demand ${ai.demand}`}>
                    🔥 Domanda: {ai.demand}
                </span>

                <span className={`tag rarity ${ai.rarity}`}>
                    💎 Rarità: {ai.rarity}
                </span>

                <span className="season">
                    {seasonIcon[ai.season]} {ai.season}
                </span>
            </div>

            {/* MOTIVATION */}
            <div className="block">
                <h3>🧠 Analisi</h3>
                <p>{ai.motivation}</p>
            </div>

            {/* TIPS */}
            <div className="block">
                <h3>🚀 Consigli di vendita</h3>
                <ul>
                    {tips.map((tip, i) => (
                        <li key={i}>{tip}</li>
                    ))}
                </ul>
            </div>
        </div>
    );
}