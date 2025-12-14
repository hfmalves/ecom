<section class="container py-5  mw-930 lh-30">
    <h2 class="section-title text-uppercase fw-bold mb-5"><?= esc($data['section_title']) ?></h2>
    <?php foreach ($data['categories'] as $catIndex => $category): ?>
        <h4 class="mb-3"><?= esc($category['category']) ?></h4>
        <div class="accordion mb-5" id="faq_accordion_<?= $catIndex ?>">
            <?php foreach ($category['faqs'] as $faq): ?>
                <div class="accordion-item">
                    <h5 class="accordion-header" id="heading_<?= $catIndex ?>_<?= $faq['order'] ?>">
                        <button class="accordion-button collapsed" type="button"
                                data-bs-toggle="collapse"
                                data-bs-target="#collapse_<?= $catIndex ?>_<?= $faq['order'] ?>"
                                aria-expanded="false"
                                aria-controls="collapse_<?= $catIndex ?>_<?= $faq['order'] ?>">
                            <?= esc($faq['question']) ?>
                        </button>
                    </h5>
                    <div id="collapse_<?= $catIndex ?>_<?= $faq['order'] ?>"
                         class="accordion-collapse collapse"
                         aria-labelledby="heading_<?= $catIndex ?>_<?= $faq['order'] ?>"
                         data-bs-parent="#faq_accordion_<?= $catIndex ?>">
                        <div class="accordion-body">
                            <p><?= esc($faq['content']) ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endforeach; ?>
</section>