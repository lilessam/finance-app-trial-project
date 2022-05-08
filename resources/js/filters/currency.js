export default function (value) {
	const formatter = new Intl.NumberFormat("en-US", {
		currency: "usd",
		minimumFractionDigits: 2,
		style: "currency",
	});
	return formatter.format(value);
}
