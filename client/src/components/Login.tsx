import React from 'react';
import { useForm } from 'react-hook-form';
import { getNewToken } from '../auth/token';

type LoginFormData = {
  email: string;
  password: string;
};

const Login: React.FC<{ setToken: React.Dispatch<React.SetStateAction<string | null>> }> = (props) => {
  const setToken: React.Dispatch<React.SetStateAction<string | null>> = props.setToken;

  const { register, handleSubmit, errors } = useForm<LoginFormData>();
  const onSubmit = ({ email, password }: { email: string; password: string }) => {
    getNewToken(email, password)
      .then((response: Response) => response.json())
      .then((token: { token: string }) => {
        localStorage.setItem('token', token.token);
        setToken(token.token);
      });
  };

  return (
    <form onSubmit={handleSubmit(onSubmit)}>
      <input name="email" type="email" ref={register({ required: true })} />
      <input name="password" type="password" ref={register({ required: true })} />
      {errors && <span>This field is required</span>}
      <input type="submit" value="Save" />
    </form>
  );
};

export default Login;
