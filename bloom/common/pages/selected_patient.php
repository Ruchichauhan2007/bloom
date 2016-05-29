<p id="selectedPatient">
<span></span>
<img style="height:42px; width:42px; border-radius:50%;" src="/gladstone/portal/bloom/portalLearn/images/learn_patient_img.jpg" alt="">

</p>
<script>
	$(function(){
		$('#selectedPatient').find('img').attr('src',$('#contextPatientImage').val());
		$('#selectedPatient').find('span').html($('#contextPatientName').val());
	});
</script>
