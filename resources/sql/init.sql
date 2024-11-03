CREATE EXTENSION IF NOT EXISTS "uuid-ossp";

CREATE TYPE transaction_type_def AS ENUM('income', 'expense');

CREATE TABLE IF NOT EXISTS users (
    id UUID PRIMARY KEY DEFAULT uuid_generate_v4(),
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP NOT NULL,
    updated_at TIMESTAMP
);

CREATE TABLE IF NOT EXISTS users_transactions (
    id UUID PRIMARY KEY DEFAULT uuid_generate_v4(),
    amount MONEY NOT NULL,
    description TEXT,
    transaction_type transaction_type_def,
    user_id UUID NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE,
    created_at TIMESTAMP NOT NULL
);

CREATE TABLE IF NOT EXISTS users_balance (
    id UUID PRIMARY KEY DEFAULT uuid_generate_v4(),
    balance MONEY NOT NULL DEFAULT 0,
    user_id UUID NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE
);