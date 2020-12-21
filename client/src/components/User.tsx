import React from 'react';
import { UserData } from '../api/user';

type UserProps = { user: UserData };

const User: React.FC<UserProps> = ({ user }) => {
  return (
    <span>
      {user.email} - {user.firstName} {user.lastName}
    </span>
  );
};

export default User;
