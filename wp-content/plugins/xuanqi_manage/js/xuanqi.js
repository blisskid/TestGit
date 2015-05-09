function saveProduct() {

    if ("" == recordTime || !/^[0-9]*$/.test(recordTime)) {
        alert("Record time should be integer!" + recordTime);
        return;
    }
}