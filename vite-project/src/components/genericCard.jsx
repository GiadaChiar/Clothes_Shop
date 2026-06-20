import { useEffect, useState } from "react";
import "../style/valutation.scss";

export default function GenericCard({ data }) {

    const [show, setShow] = useState(false);

    useEffect(() => {
        if (data) {
            const t = setTimeout(() => setShow(true), 100);
            return () => clearTimeout(t);
        }
    }, [data]);

    if (!data) return null;

    

    // standard 2 opptions
    const isAiMode = !!data.ai;
    const ai = isAiMode ? data.ai : data;
    const tips = isAiMode ? (data.tips || []) : [];
    const image = !isAiMode ? data.image : null;

    const seasonIcon = {
        primavera: "🌸",
        estate: "☀️",
        autunno: "🍂",
        inverno: "❄️",
    };

    return (
        <div className={`card ${show ? "show" : ""}`}>

            <div className="top">
                <h2>
                    {isAiMode ? "Valutazione AI" : "Dettaglio Prodotto"}
                </h2>
            </div>

            {/* IMAGE MODE */}
            {!isAiMode && image && (
                <div className="imageBox">
                    <img src={image} alt="item" />
                </div>
            )}

            {/* PRICE HERO (only AI mode) */}
            
                <div className="priceHero">
                    <div className="price">€ {ai.suggested_price}</div>
                    <div className="range">
                        €{ai.range_min} - €{ai.range_max}
                    </div>
                </div>
            

            {/* TAGS (only AI mode) */}
            
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
            

            {/* MOVIVATIONS */}
            {ai.motivation && (
                <div className="block">
                    <h3>🧠 Analisi</h3>
                    <p>{ai.motivation}</p>
                </div>
            )}

            {/* TIPS SOLO AI MODE */}
            {isAiMode && tips.length > 0 && (
                <div className="block">
                    <h3>🚀 Consigli di vendita</h3>
                    <ul>
                        {tips.map((tip, i) => (
                            <li key={i}>{tip}</li>
                        ))}
                    </ul>
                </div>
            )}

        </div>
    );
}