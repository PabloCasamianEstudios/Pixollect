<template>
    <div class="user-profile-container">
        <div class="profile-header">
            <div
                v-if="isCurrentUser"
                class="avatar-container"
                @click="openFileInput"
            >
                <img
                    :src="user.avatar_url || '/images/default-avatar.png'"
                    class="profile-avatar"
                    alt="User avatar"
                />
                <div class="avatar-overlay">
                    <span>Change Avatar</span>
                </div>
                <input
                    type="file"
                    ref="fileInput"
                    @change="handleFileUpload"
                    accept="image/*"
                    style="display: none"
                />
            </div>
            <img
                v-else
                :src="user.avatar_url || '/images/default-avatar.png'"
                class="profile-avatar"
                alt="User avatar"
            />

            <div class="profile-info">
                <h1>{{ user.name }}</h1>
                <p class="role-badge">{{ user.role.toUpperCase() }}</p>
            </div>
        </div>

        <div class="profile-tabs">
            <LinkTo
                :href="`/user/${user}`"
                :class="{ 'active-tab': $page.url === `/user/${user.name}` }"
            >
                PROFILE
            </LinkTo>
            <LinkTo
                :href="`/user/${user.name}/games`"
                :class="{
                    'active-tab': $page.url === `/user/${user.name}/games`,
                }"
            >
                COLLECTION
            </LinkTo>
            <LinkTo
                :href="`/user/${user.name}/achievements`"
                :class="{
                    'active-tab':
                        $page.url === `/user/${user.name}/achievements`,
                }"
            >
                ACHIEVEMENTS
            </LinkTo>
        </div>

        <div class="profile-content">
            <slot />
        </div>
    </div>
</template>

<script>
import { Link as LinkTo, usePage } from '@inertiajs/vue3';

export default {
    components: { LinkTo },
    props: {
        user: Object,
    },
    data() {
        return {
            fileInput: null,
        };
    },
    computed: {
        isCurrentUser() {
            const currentUser = usePage().props.auth.user;
            return currentUser && currentUser.id === this.user.id;
        },
    },
    methods: {
        openFileInput() {
            this.$refs.fileInput.click();
        },
        handleFileUpload(event) {
            const file = event.target.files[0];
            if (!file) return;

            const formData = new FormData();
            formData.append('avatar', file);

            this.$inertia.post(`/user/${this.user.name}/avatar`, formData, {
                preserveScroll: true,
                onSuccess: () => {
                    event.target.value = '';
                },
                onError: (errors) => {
                    alert(errors.message || 'Error uploading avatar');
                },
            });
        },
    },
    mounted() {
        this.fileInput = this.$refs.fileInput;
    },
};
</script>

<style lang="scss" scoped>
@use '../../css/variables.scss' as *;

.user-profile-container {
    max-width: 1200px;
    margin: 0 auto;
    background: #1a1a1a;
    color: white;
}

.profile-header {
    display: flex;
    align-items: center;
    padding: 2rem;
    gap: 2rem;
    background: linear-gradient(to right, #121212, #1e1e1e);
    border-bottom: 1px solid #333;
}

.profile-avatar {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid $main-color;
}

.profile-info h1 {
    margin: 0;
    font-size: 2rem;
    color: $main-color;
    text-transform: uppercase;
}

.role-badge {
    display: inline-block;
    padding: 0.3rem 0.8rem;
    background: rgba(255, 0, 64, 0.1);
    border-radius: 4px;
    font-size: 0.9rem;
    margin-top: 0.5rem;
}

.profile-tabs {
    display: flex;
    border-bottom: 1px solid #333;
    background: #121212;
}

.profile-tabs a {
    padding: 1rem 2rem;
    color: #aaa;
    text-decoration: none;
    text-transform: uppercase;
    font-weight: bold;
    letter-spacing: 1px;
    transition: all 0.3s;
}

.profile-tabs a:hover {
    color: white;
    background: rgba(255, 255, 255, 0.05);
}

.active-tab {
    color: $main-color;
    position: relative;
}

.active-tab::after {
    content: '';
    position: absolute;
    bottom: -1px;
    left: 0;
    right: 0;
    height: 3px;
    background: $main-color;
}

.profile-content {
    padding: 2rem;
}
.avatar-container {
    position: relative;
    cursor: pointer;
    display: inline-block;

    &:hover .avatar-overlay {
        opacity: 1;
    }
}

.profile-avatar {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid $main-color;
}

.avatar-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.7);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;

    span {
        color: white;
        font-size: 0.8rem;
        text-align: center;
    }
}
</style>
