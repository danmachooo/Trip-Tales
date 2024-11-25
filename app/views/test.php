<?php foreach ($tags as $tag): ?>
<div class="flex items-center">
    <input type="checkbox" id="<?= $tag['id']; ?>" class="mr-2">
    <label for="tag-<?= $tag['id']; ?>" class="text-sm"><?= $tag['name']; ?></label>
</div>
<?php endforeach; ?>