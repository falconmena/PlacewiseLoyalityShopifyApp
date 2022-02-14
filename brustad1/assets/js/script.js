// $(function() {
//     if($("#loyalty_member_checkbox").is(':checked'))
//         $("#form_loyalty_home").show();  
//     else
//         $("#form_loyalty_home").hide();
// });
function addDiscount(){
    $('#addDiscounts').modal('show')
    $('#discountLabel').text("Add Discount");
    $('#post_type').val("add");
    // $('#code').val('');
    $('#type').val('');
    $('#discount_value').val('');
    $('#points').val('');
    $('#title').val('');
}
function editDiscount(id,title,code,type,value,points){
    $('#addDiscounts').modal('show')
    $('#discountLabel').text("Edit Discount");
    $('#post_id').val(id);
    $('#post_type').val("edit");
    // $('#code').val(code);
    // $('#type').val(type);
    if(type == 1){
        $('input[id="type_per"]').attr("checked", "checked");
    }else if(type == 2){
        $('input[id="type_fixed"]').attr("checked", "checked");
    }
    $('#discount_value').val(value);
    $('#points').val(points);
    $('#title').val(title);
}
// $('#loyalty_member_checkbox').on('click',function() {
//     if($(this).is(':checked'))
//         $("#form_loyalty_home").show();  
//     else
//         $("#form_loyalty_home").hide();
// });