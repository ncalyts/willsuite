<template>
  <div class="w-screen">
    <div v-if="isLoading">Loading Notes...</div>
    <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8" v-else>
        <note-form 
            @completed="addNote" 
            @updated="updateNote" 
            :noteId="id" 
            :noteTitle="title" 
            :noteContent="content"
            :editButtonText="buttonText">
        </note-form>
        <table class="min-w-full text-left text-sm font-light">
            <thead class="border-b bg-white font-medium dark:border-neutral-500 dark:bg-neutral-600">
                <tr>
                    <th scope="col" class="px-6 py-4">ID</th>
                    <th scope="col" class="px-6 py-4">Title</th>
                    <th scope="col" class="px-6 py-4">Content</th>
                    <th scope="col" class="px-6 py-4">Created</th>
                    <th scope="col" class="px-6 py-4">Actions</th>
                </tr>
            </thead>
            <tbody>
                    <tr class="border-b bg-neutral-100 dark:border-neutral-500 dark:bg-neutral-700" v-for="note in notes" :key="note">
                        <td class="whitespace-nowrap px-6 py-4 font-medium">{{note.id}}</td>
                        <td class="whitespace-nowrap px-6 py-4">{{note.title}}</td>
                        <td class="whitespace-nowrap px-6 py-4">{{note.content}}</td>
                        <td class="whitespace-nowrap px-6 py-4">{{note.created_at}}</td>
                        <td class="whitespace-nowrap px-6 py-4">
                            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 m-2 rounded focus:outline-none focus:shadow-outline" v-bind:class="{'is-loading' : isDeleting(note.id)}" @click="deleteNote(note.id)">Delete</button>
                            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" v-bind:class="{'is-editing' : isEditing(note.id) }" @click="editNote(note.id)">Edit</button>
                        </td>
                    </tr>
            </tbody>
        </table>
        
    </div>
  </div>
</template>

<script>
import axios from 'axios'
import { API_BASE_URL } from '@/config';
import NoteForm from './NoteForm.vue';

export default {
    components: {
        NoteForm
    },
    data() {
        return {
            isLoading: true,
            id: '',
            title: '',
            buttonText: 'Add Note',
            content: '',
            notes: {}
        }
    },
    async created() {
        try {
            const response = await axios.get(API_BASE_URL + '/notes')
            this.notes = response.data.data
            this.isLoading = false
        } catch (e) {
            //TODO: do something with error 
        }
    },
    methods: {
        addNote(note) {
            this.notes.push(note)
        },
        updateNote(noteUpdate) {
            let index = this.notes.findIndex(note => note.id === noteUpdate.id)
            this.notes[index] = noteUpdate
        },
        isDeleting(id) {
            let index = this.notes.findIndex(note => note.id === id)
            return this.notes[index].isDeleting
        },
        async deleteNote(id) {
            let index = this.notes.findIndex(note => note.id === id) 
            await axios.delete(API_BASE_URL + '/notes/' + id)
            this.notes.splice(index, 1)
        },
        isEditing(id) {
            //TODO
        },
        async editNote(id) {
            let index = this.notes.findIndex(note => note.id === id);
            try {
                const response = await axios.get(API_BASE_URL + '/notes/' + id)
                this.id = response.data.data.id
                this.title = response.data.data.title
                this.content = response.data.data.content
                this.buttonText = "Edit Note"
                
            } catch (e) {
                //TODO
            }
        }
    }
}
</script>

<style>

</style>