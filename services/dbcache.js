export default {

    getUserName(users, userId) {
        let output = '';
        for (var user = 0; user < users.length; user++) {
            if (users[user].id == userId) {
                output = users[user].firstName + ' ' + users[user].lastName;
                break;
            }
        }
        return output;
    },


}