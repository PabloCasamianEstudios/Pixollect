<template>
    <metaHead>
        <title>Privacy</title>
        <meta
            head-key="description"
            name="description"
            content="Privacy Policy of Pixollect"
        />
    </metaHead>
    <div class="outer-container">
        <div class="inner-bordered-box">
            <h1 class="page-title">Privacy Policy</h1>

            <p>
                Pixollect respects your privacy. This policy explains what data
                we collect, why we collect it, and how we protect it. By using
                this platform, you consent to the practices described here.
            </p>

            <h2 class="section-title">Data Collected</h2>
            <p>We collect the following information when you use Pixollect:</p>
            <ul>
                <li>Username and email (for authentication)</li>
                <li>
                    Your game collection and progress (statuses, achievements,
                    hours, ratings)
                </li>
                <li>
                    Basic usage data to improve the platform (e.g., preferences
                    or filters)
                </li>
            </ul>

            <h2 class="section-title">Data Usage</h2>
            <p>
                Your data is used solely to offer you the services of the
                platform: collection tracking, recommendations, comparisons, and
                statistics.
            </p>

            <h2 class="section-title">Data Protection</h2>
            <p>
                All personal data is securely stored. Passwords are encrypted
                using secure hashing. Sensitive operations are protected with
                role-based access and validated server-side.
            </p>

            <h2 class="section-title">User Rights</h2>
            <p>
                You may request deletion of your account and data at any time.
                We do not sell or share your data with third parties. Backup
                copies are made periodically to prevent loss.
            </p>

            <h2 class="section-title">Compliance</h2>
            <p>
                Pixollect follows the GDPR (General Data Protection Regulation)
                guidelines. Only the minimum required data is stored, and users
                retain control over their information.
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
ul {
    margin-bottom: 1rem;
    padding-left: 1.5rem;
    list-style: disc;

    li {
        margin-bottom: 0.5rem;
    }
}
</style>
