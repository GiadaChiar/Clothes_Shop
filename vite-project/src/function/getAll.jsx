import { loginUser } from "../api/authApi";

export const getAllValutations = async (user_id) => {

    console.log("user_id in nuova funazione all: ", user_id)
    return await loginUser({
        request: "all",
        user_id: user_id,
    });
};