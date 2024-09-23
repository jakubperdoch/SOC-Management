export function getUrl(endpointTemplate: string, values: string) {
	return endpointTemplate.replace(/{(\w+(\.\w+)*)}/g, (match, key) => {
		const keys = key.split('.');
		let replacement = values;

		for (const k of keys) {
			replacement = replacement[k];

			if (replacement === undefined) {
				return '';
			}
		}

		return replacement !== undefined ? replacement : '';
	});
}

export function useSubdomain() {
	const url = useRequestURL();
	return url.hostname.split('.')[0];
}
