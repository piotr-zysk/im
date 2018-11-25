export default {

    getList(items) {
        var output = [];
        items.forEach(element => {
            output.push(element.id);
        });
        return output;


    }

}