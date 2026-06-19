export default function timeout(ms) {
    return new Promise((_, reject) =>
        setTimeout(() => reject(new Error("TIMEOUT")), ms)
    );
}