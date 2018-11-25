export default {

    getList(items) {
        var output = [];
        items.forEach(element => {
            output.push(element.id);
        });
        return output;
    },

    // returns the id of next element (to be used for "next Message" button when browsing messages)
    getNext(items,givenId) {
        var output=-1;
        for (var i=0; i<(items.length-1); i++)
        {
            if (givenId==items[i])
            {
                output=items[i+1];
                break;
            }
        }
        return output;
    }

}