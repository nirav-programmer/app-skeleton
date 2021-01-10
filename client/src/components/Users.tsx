import React from 'react';
import { UserData } from '../api/user';

type UserProps = { user: UserData };
type UsersProps = { users: UserData[] };

const User: React.FC<UserProps> = ({ user }) => {
  return (
    <li>
      {user.email} - {user.firstName} {user.lastName}
    </li>
  );
};

const Users: React.FC<UsersProps> = ({ users }) => {
  const userItems = users.map((user: UserData) => <User key={user.id} user={user} />);

  return <ul>{userItems}</ul>;
};

export default Users;
