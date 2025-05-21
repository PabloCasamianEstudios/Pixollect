<template>
         <metaHead>
            <title>Terms and Conditions</title>
            <meta
                head-key="description"
                name="description"
                content="Terms and Conditions of Pixollect"
            />
        </metaHead>
    <div class="outer-container">
        <div class="inner-bordered-box">
            <h1 class="page-title">Terms and Conditions</h1>

            <p>
                By accessing or using Pixollect, you agree to comply with the
                following terms and conditions. These terms are subject to
                change without prior notice. It is your responsibility to review
                them regularly.
            </p>

            <h2 class="section-title">License of Use</h2>
            <p>
                Pixollect is distributed under a non-exclusive usage license.
                Users are allowed to access and use the platform and all its
                functionalities free of charge. Redistribution or modification
                of the source code is strictly prohibited unless otherwise
                authorized by the developer.
            </p>

            <h2 class="section-title">Access and Modifications</h2>
            <p>
                The developer reserves the right to modify the application at
                any time to improve functionality, correct errors, or add
                features. These changes will not negatively affect basic
                usability.
            </p>

            <h2 class="section-title">Intellectual Property</h2>
            <p>
                All intellectual property, including source code, databases, and
                visual content, belongs to the developer. Users may not claim
                ownership of any part of the platform.
            </p>

            <h2 class="section-title">Open Source Distribution</h2>
            <p>
                Pixollect is available as open source under the MIT License. You
                are allowed to view, use, copy, modify, and distribute the code
                with attribution to the original author. Commercial use requires
                prior permission from the developer.
            </p>
        </div>
    </div>
</template>

<script>
import { Head as metaHead } from '@inertiajs/vue3';

export default {
    components: {
        metaHead,
    },
};
</script>

<style scoped lang="scss">
@use '../../css/variables.scss' as *;
.outer-container {
    max-width: 900px;
    margin: 2rem auto;
    padding: 1.5rem;
    background-color: #1c1c1c;
    border-radius: 12px;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.5);
}
.inner-bordered-box {
    border: 1px dashed $main-color;
    padding: 2rem;
    border-radius: 8px;
    background-color: #1e1e1e;
    font-family: 'Orbitron', sans-serif;
    color: #ccc;
}
.page-title {
    font-size: 2rem;
    margin-bottom: 1.5rem;
    color: $main-color;
    text-align: center;
}
.section-title {
    font-size: 1.3rem;
    margin-top: 2rem;
    color: lighten($main-color, 10%);
}
p {
    margin-bottom: 1rem;
    line-height: 1.6;
}
</style>
