import { SearchUser } from "./SearchUser";

export const getAllValutations = async (user_id) => {

    console.log("user_id in nuova funazione all: " , user_id)
    return await SearchUser({
        request: "all",
        user_id: user_id,
    });
};