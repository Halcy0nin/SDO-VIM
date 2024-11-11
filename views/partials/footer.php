        <script src="/js/bootstrap.bundle.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                if (<?php echo json_encode(isset($_SESSION['_flash']['notification']) &&  count($_SESSION['_flash']['notification']) > 0); ?>) {
                    Toastify({
                        text: "<?php echo $_SESSION['_flash']['notification']['text'] ?? '' ?>",
                        duration: <?php echo $_SESSION['_flash']['notification']['duration'] ?? 3000 ?>,
                        close: true,
                        gravity: "bottom",
                        position: "<?php echo $_SESSION['_flash']['notification']['position'] ?? 'center' ?>",
                        backgroundColor: "<?php echo $_SESSION['_flash']['notification']['bg'] ?? '#535E7D' ?>",
                        stopOnFocus: true,
                        offset: {
                            y: '3rem'
                        },
                    }).showToast();
                }
            });          
        </script>
</html>