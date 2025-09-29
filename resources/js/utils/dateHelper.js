export function timeAgo(dateString) {
    if (!dateString) return null;

    const date = new Date(dateString);
    const now = new Date();

    const differenceMs = now - date;
    const differenceSec = Math.floor(differenceMs / 1000);
    const differenceMin = Math.floor(differenceSec / 60);
    const differenceHour = Math.floor(differenceMin / 60);
    const differenceDay = Math.floor(differenceHour / 24);
    const differenceWeek = Math.floor(differenceDay / 7);
    const differenceMonth = Math.floor(differenceDay / 30); //Not exactly right, but approaches targeted value
    const differenceYear = Math.floor(differenceDay / 365);

    if (differenceMin < 1) return 'now';
    if (differenceHour < 1) return `${differenceMin} ${differenceMin === 1 ? 'minute' : 'minutes'} ago`;
    if (differenceDay < 1) return `${differenceHour} ${differenceHour === 1 ? 'hour' : 'hours'} ago`;
    if (differenceWeek < 1) return `${differenceDay} ${differenceDay === 1 ? 'day' : 'days'} ago`;
    if (differenceMonth < 1) return `${differenceWeek} ${differenceWeek === 1 ? 'week' : 'weeks'} ago`;
    if (differenceYear < 1) return `${differenceMonth} ${differenceMonth === 1 ? 'month' : 'months'} ago`;

    return `${differenceYear} ${differenceYear === 1 ? 'year' : 'years'} ago`;
}
