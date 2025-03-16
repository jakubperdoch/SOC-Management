/**
 * Returns a formatted date string
 * @param {String | undefined} date
 * @param {Object} [options]
 * @returns {String} formatted date string
 */
const getFormattedDate = (date, options = {}) => {
	if (!date) {
		return ''
	}

	const formatOptions = {
		year: 'numeric',
		month: 'short',
		day: 'numeric',
		...options
	}

	return new Intl.DateTimeFormat('sk-SK', formatOptions).format(new Date(date))
}

export default getFormattedDate
