<?php include "templates/include/header.php" ?>

<h1><?php echo htmlspecialchars($results['pageHeading']); ?></h1>

<?php
// Определяем тип текущего вывода: категория или подкатегория
$currentType = '';
if (isset($results['category']) && $results['category']) {
    $currentType = 'category';
} elseif (isset($results['subcategory']) && $results['subcategory']) {
    $currentType = 'subcategory';
}
?>

<?php if ($currentType === 'category') { ?>
    <h3 class="categoryDescription"><?php echo htmlspecialchars($results['category']->description); ?></h3>
<?php } elseif ($currentType === 'subcategory') { ?>
    <h3 class="categoryDescription"><?php echo htmlspecialchars($results['subcategory']->description); ?></h3>
<?php } ?>

<ul id="headlines" class="archive">

<?php foreach ($results['articles'] as $article) { ?>

    <li>
        <h2>
            <span class="pubDate">
                <?php echo date('j F Y', $article->publicationDate); ?>
            </span>
            <a href=".?action=viewArticle&amp;articleId=<?php echo $article->id; ?>">
                <?php echo htmlspecialchars($article->title); ?>
            </a>

            <?php
            // Показываем категорию, если текущая страница не категория
            if ($currentType !== 'category' && isset($article->categoryId) && $article->categoryId) {
                ?>
                <span class="category">
                    in 
                    <a href=".?action=archive&amp;categoryId=<?php echo $article->categoryId; ?>">
                        <?php echo htmlspecialchars($results['categories'][$article->categoryId]->name); ?>
                    </a>
                </span>
                <?php
            }
            ?>

            <?php
            // Показываем подкатегорию, если есть
            if (isset($article->subcategoryId) && $article->subcategoryId) {
                $subcategory = Subcategory::getById($article->subcategoryId);
                ?>
                <span class="subcategory">
                    / 
                    <a href=".?action=archiveBySubcategory&amp;subcategoryId=<?php echo $article->subcategoryId; ?>">
                        <?php echo $subcategory ? htmlspecialchars($subcategory->name) : 'Unknown'; ?>
                    </a>
                </span>
                <?php
            }
            ?>
        </h2>
        <p class="summary"><?php echo htmlspecialchars($article->summary); ?></p>
    </li>

<?php } ?>

</ul>

<p><?php echo $results['totalRows']; ?> article<?php echo ($results['totalRows'] != 1) ? 's' : ''; ?> in total.</p>

<p><a href="./">Return to Homepage</a></p>

<?php include "templates/include/footer.php" ?>