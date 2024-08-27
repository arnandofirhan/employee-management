const handleGetSeparator = (locale = "en-US") => {
    return {
        thousand: Intl.NumberFormat(locale)
            .format(11111)
            .replace(/\p{Number}/gu, ""),
        decimal: Intl.NumberFormat(locale)
            .format(1.1)
            .replace(/\p{Number}/gu, ""),
    };
};

const handleNumberFormat = (locale = "en-US", value = 0, fixedValue = 0) => {
    return new Intl.NumberFormat(locale, {
        minimumFractionDigits: fixedValue,
        maximumFractionDigits: 2,
    }).format(value);
};

const handleParseLocaleNumber = (locale = "en-US", stringValue = 0) => {
    const separator = handleGetSeparator(locale);

    if (stringValue === "") {
        stringValue = "0";
    }

    return parseFloat(
        stringValue
            .replace(new RegExp("\\" + separator.thousand, "g"), "")
            .replace(new RegExp("\\" + separator.decimal), ".")
    );
};
