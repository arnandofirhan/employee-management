const handleTimeFormat = (
    locale = "en-US",
    time,
    format = {
        year: "numeric",
        month: "numeric",
        day: "numeric",
    }
) => {
    return new Date(time).toLocaleString(locale, format);
};
