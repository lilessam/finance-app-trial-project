export default function (value) {
	var result = Math.round(parseInt(value)/1000)*1000;
    return result.toString().substring(0, 2);
}
