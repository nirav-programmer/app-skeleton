export interface UserData {
  id: string;
  email: string;
  firstName: string;
  lastName: string;
}

export function listUsers() {
  const url = getApiUrl('/users');

  return fetch(url, {
    headers: createHeaders(),
    method: 'GET',
    mode: 'cors',
  }).then((response) => response.json());
}

export function getUser(userId: string) {
  const url = getApiUrl('/users/{id}', userId);

  return fetch(url, {
    headers: createHeaders(),
    method: 'GET',
    mode: 'cors',
  }).then((response) => response.json());
}

export function createUser(data: UserData) {
  const url = getApiUrl('/api/users');

  return fetch(url, {
    body: JSON.stringify({
      email: data.email,
      firstName: data.firstName,
      lastName: data.lastName,
    }),
    headers: createHeaders(),
    method: 'POST',
    mode: 'cors',
  });
}

export function updateUser(userId: string, data: UserData) {
  const url = getApiUrl('/users/{id}', userId);

  return fetch(url, {
    body: JSON.stringify(data),
    headers: createHeaders(),
    method: 'PATCH',
    mode: 'cors',
  });
}

export function deleteUser(userId: string) {
  const url = getApiUrl('/users/{id}', userId);

  return fetch(url, {
    headers: createHeaders(),
    method: 'DELETE',
    mode: 'cors',
  });
}

function getApiUrl(route: string, userId?: string) {
  const baseUrl = process.env.API_BASE_URL;

  if (userId) {
    return baseUrl + route.replace('{id}', userId);
  }

  return baseUrl + route;
}

function createHeaders() {
  const headers = new Headers();
  headers.append('Accept', 'application/json');
  headers.append('Content-Type', 'application/json');

  return headers;
}
