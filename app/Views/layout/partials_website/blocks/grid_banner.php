<section class="grid-banner container mb-3" id="section-grid-banner">
    <div class="row">
        <!-- BLOCO 1 -->
        <div class="col-lg-4">
            <div class="grid-banner__item position-relative mb-3">
                <?php
                $img1 = $data['block_1_img'] ?? '';
                $img1Path = FCPATH . 'uploads/blocks/large/' . $img1;
                $img1Src = (!empty($img1) && file_exists($img1Path))
                    ? base_url('uploads/blocks/large/' . $img1)
                    : base_url('uploads/no-picture-available.jpg');
                ?>
                <img loading="lazy" class="w-100 h-auto" src="<?= $img1Src ?>" width="450" height="450" alt="Bloco 1">
                <div class="content_abs content_center text-center">
                    <?php if (!empty($data['block_1_title'])): ?>
                        <h3 class="text-uppercase fw-bold mb-1"><?= $data['block_1_title'] ?></h3>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- BLOCO 2 -->
        <div class="col-lg-4">
            <div class="grid-banner__item position-relative mb-3">
                <?php
                $img2 = $data['block_2_img'] ?? '';
                $img2Path = FCPATH . 'uploads/blocks/large/' . $img2;
                $img2Src = (!empty($img2) && file_exists($img2Path))
                    ? base_url('uploads/blocks/large/' . $img2)
                    : base_url('uploads/no-picture-available.jpg');
                ?>
                <img loading="lazy" class="w-100 h-auto" src="<?= $img2Src ?>" width="450" height="450" alt="Bloco 2">
                <div class="content_abs content_center text-center">
                    <?php if (!empty($data['block_2_title'])): ?>
                        <h3 class="text-uppercase fw-bold mb-1"><?= $data['block_2_title'] ?></h3>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- BLOCO 3 -->
        <div class="col-lg-4">
            <div class="grid-banner__item position-relative mb-3">
                <?php
                $img3 = $data['block_3_img'] ?? '';
                $img3Path = FCPATH . 'uploads/blocks/large/' . $img3;
                $img3Src = (!empty($img3) && file_exists($img3Path))
                    ? base_url('uploads/blocks/large/' . $img3)
                    : base_url('uploads/no-picture-available.jpg');
                ?>
                <img loading="lazy" class="w-100 h-auto" src="<?= $img3Src ?>" width="450" height="450" alt="Bloco 3">
                <div class="content_abs content_center text-center text-white">
                    <?php if (!empty($data['block_3_subtitle'])): ?>
                        <p class="mb-1"><?= esc($data['block_3_subtitle']) ?></p>
                    <?php endif; ?>

                    <?php if (!empty($data['block_3_title'])): ?>
                        <h3 class="text-uppercase fw-bold mb-1"><?= $data['block_3_title'] ?></h3>
                    <?php endif; ?>

                    <?php if (!empty($data['block_link_value'])): ?>
                        <a href="<?= base_url($data['block_link_value']) ?>" class="btn-link default-underline text-uppercase text-white fw-medium">Ver mais</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>
