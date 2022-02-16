   <!-- Bootstrap core JavaScript-->
   <script src="../../assets/vendor/jquery/jquery.min.js"></script>
   <script src="../../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
   <script src="../../assets/vendor/jquery-easing/jquery.easing.min.js"></script>
   <script src="../../assets/js/sb-admin-2.min.js"></script>
   <!-- Page level plugins dataTables -->
   <script src="../../assets/vendor/datatables/jquery.dataTables.min.js"></script>
   <script src="../../assets/vendor/datatables/dataTables.bootstrap4.min.js"></script>
   <script src="../../assets/js/demo/datatables-demo.js"></script>


   <script>
      function myAlery() {
         Swal.fire({
            title: 'สำเร็จ!',
            text: 'บันทึกข้อมูลสำเร็จ',
            icon: 'success',
            timer: 1500,
            showConfirmButton: false,
         })
      }

      function myAleryError() {
         Swal.fire({
            title: 'ผิดผลาด!',
            text: 'ตรวจสอบคะแนน',
            icon: 'error',
            timer: 1500,
            showConfirmButton: false,
         })
      }

      function confirmAlert(id) {
         Swal.fire({
            title: 'ยืนยันการลบ',
            text: `ต้องการลบข้อมูลหรือไม่`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#1CC88A',
            cancelButtonColor: '#E74A3B',
            confirmButtonText: 'ตกลง',
            cancelButtonText: 'ยกเลิก'
         }).then((result) => {
            if (result.isConfirmed) {
               location.assign(`./server/article_del.php?id=${id}`);
            }
         })
      }
   </script>