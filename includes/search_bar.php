<form method="get" class="mb-4">
    <div class="input-group">
        <input type="hidden" name="page" value="<?php echo htmlspecialchars($_GET['page'] ?? ''); ?>">
        <?php if (isset($_GET['admin_page'])): ?>
            <input type="hidden" name="admin_page" value="<?php echo htmlspecialchars($_GET['admin_page']); ?>">
        <?php endif; ?>
        <?php if (isset($_GET['category'])): ?>
            <input type="hidden" name="category" value="<?php echo htmlspecialchars($_GET['category']); ?>">
        <?php endif; ?>
        <input type="text" name="search" class="form-control" 
               placeholder="Search..." 
               value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
        <button class="btn btn-primary" type="submit">Search</button>
        <?php if (isset($_GET['search'])): ?>
            <?php
            $params = $_GET;
            unset($params['search']);
            $query = http_build_query($params);
            $url = strtok($_SERVER["REQUEST_URI"], '?');
            $clearUrl = $url . ($query ? '?' . $query : '');
            ?>
            <a href="<?php echo htmlspecialchars($clearUrl); ?>" class="btn btn-secondary">Clear</a>
        <?php endif; ?>
    </div>
</form> 