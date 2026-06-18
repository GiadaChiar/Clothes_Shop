

/*console.log("my vite url: ", API_URL)

export async function ApiFetch(data) {
    const response = await fetch(`${API_URL}/api/auth/login`, {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify(data)
    });

    const result = await response.json()


    console.log("stampo", result);

    if (!result.ok) {
        console.error(result.error);
    }


    return result;
}*/



//api client baase

export async function apiRequest(endpoint, options = {}) {
    const API_URL = import.meta.env.VITE_API_URL;

    const response = await fetch(`${API_URL}${endpoint}`, {
        headers: {
            "Content-Type": "application/json",
            ...(options.headers || {})
        },
        ...options
    });

    const result = await response.json();

    console.log("stampo", result);

    if (!response.ok) {
        throw new Error(result?.error || "API error");
    }

    return result;
}


