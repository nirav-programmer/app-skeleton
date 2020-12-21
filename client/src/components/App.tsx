import React, { useEffect, useState } from 'react';
import Login from './Login';
import './App.css';
import { getUserCollection, HydraCollection } from '../api/user';
import Users from './Users';
import { getStoredToken, removeToken } from '../auth/token';

const App: React.FC = () => {
  const [token, setToken] = useState<string | null>(getStoredToken());
  const [componentToDisplay, setComponentToDisplay] = useState<React.ReactElement>();
  const [errorMessage, setErrorMessage] = useState<string>('');

  useEffect(() => {
    if (null === token) {
      setComponentToDisplay(<Login setToken={setToken} />);
    } else {
      getUserCollection(1, 10, token)
        .then((response: Response) => {
          return {
            data: response.json(),
            responseStatus: response.status,
          };
        })
        .then((result: { data: Promise<HydraCollection>; responseStatus: number }) => {
          if (401 === result.responseStatus) {
            removeToken();
            setComponentToDisplay(<Login setToken={setToken} />);
          } else {
            result.data.then((users) => setComponentToDisplay(<Users users={users['hydra:member']} />));
          }
        })
        .catch((error) => setErrorMessage(error.message));
    }
  }, [token]);

  return (
    <div className="App">
      {errorMessage ? <p>Encountered error: &quot{errorMessage}&quot</p> : <div>{componentToDisplay}</div>}
    </div>
  );
};

export default App;
