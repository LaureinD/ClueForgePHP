export function ucFirst(string) {
    if (!string) return '';

    return string[0].toUpperCase() + string.slice(1);
}
