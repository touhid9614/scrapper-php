$("#date_range").change(function () {
    if (this.value == "custom") {
        $("#custom_date_range").show();
    } else {
        $("#custom_date_range").hide();
    }
});