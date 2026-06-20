

//api client base
export async function apiRequest(endpoint, options = {}) {
    const API_URL = import.meta.env.VITE_API_URL;

    let response;

    try {
        response = await fetch(`${API_URL}${endpoint}`, {
            headers: {
                "Content-Type": "application/json",
                ...(options.headers || {})
            },
            ...options
        });
    } catch{
        // Network error
        throw new Error("Problema di connessione al server");
    }

    let result;

    try {
        result = await response.json();
    } catch {
        // tecnic error
        throw new Error("Risposta server non valida");
    }

    console.log("stampo", result);

    return result;
}

