//send data to back-end


export async function SearchUser(data) {
    const response = await fetch(
        "/api/frontData.php",
        {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify(data),
        }
    );


    
    const result = await response.json();
    console.log("stampo  ", result)

    return result;
}