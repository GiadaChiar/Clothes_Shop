import { getAllValutations } from "../api/authApi";

export async function AllValutations (user_id){
    return await getAllValutations({
        request: "all",
        user_id,
    });
};




