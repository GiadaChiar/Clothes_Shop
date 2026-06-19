
import { loginUser } from "../api/authApi";
import { registerUser } from "../api/authApi";

export async function loginService(email, password) {
    return await loginUser({
        request: "login",
        email,
        password
    });
}


export async function registartionService(email,
    name,
    surname,
    password_hash) {
    return await registerUser({
        request: "registration",
        email,
        name,
        surname,
        password_hash
    });
}