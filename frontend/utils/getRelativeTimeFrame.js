/**
 * Returns relative time frame
 * @param {string | undefined} dateString
 * @example getRelativeDate('2024-10-10') // 10 minutes ago
 * @returns {string}
 * @author David
 */
const getRelativeTimeFrame = (dateString) => {
	if (!dateString) return ''

	const dateObject = new Date(dateString)

	const secondsDiff = Math.round((dateObject - Date.now()) / 1000)

	const unitsInSec = [
		60,
		3600,
		86400,
		86400 * 7,
		86400 * 30,
		86400 * 365,
		Infinity
	]

	const unitStrings = [
		'second',
		'minute',
		'hour',
		'day',
		'week',
		'month',
		'year'
	]

	const unitIndex = unitsInSec.findIndex(
		(cutoff) => cutoff > Math.abs(secondsDiff)
	)

	const divisor = unitIndex ? unitsInSec[unitIndex - 1] : 1

	const rtf = new Intl.RelativeTimeFormat('sk', { numeric: 'auto' })

	const relativeTime = rtf.format(
		Math.floor(secondsDiff / divisor),
		unitStrings[unitIndex]
	)

	return relativeTime
}

export default getRelativeTimeFrame
