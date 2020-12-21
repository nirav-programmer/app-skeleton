const getStoredToken = (): string | null => {
  const token = localStorage.getItem('token');
  if (null === token || '' === token) {
    return null;
  }

  return token;
};

const getNewToken = (email: string, password: string): Promise<Response> => {
  const baseUrl = process.env.API_BASE_URL;
  const url = baseUrl + '/authentication_token';

  const headers = new Headers();
  headers.append('Accept', 'application/ld+json');
  headers.append('Content-Type', 'application/ld+json');

  return fetch(url, {
    body: JSON.stringify({ email: email, password: password }),
    headers: headers,
    method: 'POST',
    mode: 'cors',
  });
};

const removeToken = (): void => {
  localStorage.removeItem('token');
};

export { getNewToken, getStoredToken, removeToken };
