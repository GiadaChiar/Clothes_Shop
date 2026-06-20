import "../style/loading.scss";

export default function Loading() {
    return (
        <div className="loadingWrapper">
            <div className="spinner"></div>
            <p>Caricamento...</p>
        </div>
    );
}