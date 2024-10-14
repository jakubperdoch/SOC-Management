import { useRuntimeConfig } from '#imports';
import { $fetch } from 'ofetch';
import { useSubdomain } from './utils';
interface ApiFetchOptions extends RequestInit {
	headers?: Record<string, string>;
	params?: Record<string, any>;
	body?: any;
	query?: Record<string, any>;
}

const handlePayload = (body: any) => {
	let payload = body;
	let hasFiles = false;

	if (body instanceof FormData) {
		hasFiles = true;
	} else if (typeof body === 'object' && body !== null) {
		for (const key in body) {
			if (body[key] instanceof File || body[key] instanceof Blob) {
				hasFiles = true;
				break;
			}
		}

		if (hasFiles) {
			payload = new FormData();
			for (const key in body) {
				if (Object.prototype.hasOwnProperty.call(body, key)) {
					payload.append(key, body[key]);
				}
			}
		}
	}

	return { payload, hasFiles };
};

const apiFetch = async (
	url: string,
	options: ApiFetchOptions = {}
): Promise<any> => {
	const config = useRuntimeConfig();
	const baseUrl = config.public.API_BASE_URL;
	const tokenCookie = useCookie('accessToken');
	const token = tokenCookie.value;
	const domainHost = useSubdomain();

	options.headers = options.headers || {};

	if (token) {
		options.headers.Authorization = `Bearer ${token}`;
	}

	if (options.body) {
		const { payload, hasFiles } = handlePayload(options.body);
		options.body = payload;

		if (
			hasFiles &&
			['PUT', 'PATCH'].includes((options.method || '').toUpperCase())
		) {
			options.method = 'POST';
			options.query = {
				...(options.query || {}),
				_method: 'PATCH',
			};
		}

		if (!hasFiles) {
			options.headers['Content-Type'] = 'application/ld+json';
		} else {
			delete options.headers['Content-Type'];
		}
	}

	try {
		const response = await $fetch(url, {
			baseURL: baseUrl,
			...options,
		});
		return response;
	} catch (error) {
		console.error('API Fetch Error:', error);
		throw error;
	}
};

export default apiFetch;
