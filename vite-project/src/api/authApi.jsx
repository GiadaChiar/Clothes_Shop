import { apiRequest } from "./apiClient";

export function registerUser(data) {
    return apiRequest("/api/auth/register", {
        method: "POST",
        body: JSON.stringify(data)
    });
}

export function loginUser(data) {
    return apiRequest("/api/auth/login", {
        method: "POST",
        body: JSON.stringify(data)
    });
}


export function valutation(data) {
    return apiRequest("/api/item/new", {
        method: "POST",
        body: JSON.stringify(data)
    })
}


export function getAllValutations(data) {
    return apiRequest("/api/item/all", {
        method: "POST",
        body: JSON.stringify(data)
    })
}