const express = require('express');
const router = express.Router();
const User = require('../models/User');
const crypto = require('crypto');

router.post('/invite', async (req, res) => {
    const email = req.body.email;

    try {
        const inviteToken = crypto.randomBytes(16).toString('hex');

        const newUser = new User({
            email: email,
            inviteToken: inviteToken
        });

        await newUser.save();

        const inviteLink = `${req.protocol}://${req.get('host')}/invite?token=${inviteToken}`;
        res.status(201).json({ inviteLink });
    } catch (error) {
        res.status(500).json({ message: 'Error generating invite link' });
    }
});

module.exports = router;
