<?php if (ceil($total_records / $num_results_on_page) > 0): ?>
    <ul class="pagination">
        <?php if ($page > 1): ?>
            <li class="prev"><a href="?page=<?php echo $page-1 ?>">Prev</a></li>
        <?php endif; ?>

        <?php if ($page > 3): ?>
            <li class="start"><a href="?page=1">1</a></li>
            <li class="dots">...</li>
        <?php endif; ?>

        <?php for ($i = max(1, $page - 2); $i <= min($page + 2, ceil($total_records / $num_results_on_page)); $i++): ?>
            <li class="<?php echo ($i == $page) ? 'currentpage' : 'page'; ?>"><a href="?page=<?php echo $i ?>"><?php echo $i ?></a></li>
        <?php endfor; ?>

        <?php if ($page < ceil($total_records / $num_results_on_page) - 2): ?>
            <li class="dots">...</li>
            <li class="end"><a href="?page=<?php echo ceil($total_records / $num_results_on_page) ?>"><?php echo ceil($total_records / $num_results_on_page) ?></a></li>
        <?php endif; ?>

        <?php if ($page < ceil($total_records / $num_results_on_page)): ?>
            <li class="next"><a href="?page=<?php echo $page+1 ?>">Next</a></li>
        <?php endif; ?>
    </ul>
<?php endif; ?>