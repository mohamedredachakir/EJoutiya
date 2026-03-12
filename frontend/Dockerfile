FROM node:22-alpine

WORKDIR /app

# We don't need a specific user for node in most cases if we just use volumes,
# but if the user wants no permission issues, we can match the UID as well.
# However, alpine uses 'node' user with UID 1000 by default.

COPY package*.json ./

RUN npm install

COPY . .

EXPOSE 5173

CMD ["npm", "run", "dev", "--", "--host"]
