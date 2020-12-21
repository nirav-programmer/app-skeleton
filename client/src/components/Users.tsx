import React from 'react';
import { UserData } from '../api/user';
import User from './User';

type UsersProps = { users: UserData[] };

const Users: React.FC<UsersProps> = ({ users }) => {
  const userItems = users.map((user) => (
    <li key={user.id}>
      <User user={user} />
    </li>
  ));

  return <ul>{userItems}</ul>;
};

export default Users;
