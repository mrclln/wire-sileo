import React from 'react';
import { createRoot } from 'react-dom/client';
import { sileo, Toaster } from 'sileo';
import * as Icons from 'lucide-react';

const root = document.getElementById('sileo-portal');
if (!root) {
    throw new Error('wire-sileo: Missing <div id="sileo-portal"> element. Add <livewire:wire-sileo /> to your layout.');
}

const position = root.dataset.position || 'top-right';
const theme = root.dataset.theme || 'system';
const fill = root.dataset.fill || undefined;
const roundness = Number(root.dataset.roundness || 16);

const options = {
    ...(fill ? { fill } : {}),
    ...(roundness ? { roundness } : {}),
};

createRoot(root).render(
    React.createElement(Toaster, {
        position,
        theme,
        options,
    }),
);

const renderIcon = (icon) => {
    if (!icon) return null;

    if (typeof icon === 'string') {
        const camelName = icon.replace(/-([a-z])/g, (_, letter) => letter.toUpperCase()).replace(/^([a-z])/, (_, letter) => letter.toUpperCase());
        const IconComponent = Icons[camelName] || Icons.Info;
        return React.createElement(IconComponent, { className: 'size-3.5' });
    }

    if (React.isValidElement(icon)) {
        return icon;
    }

    return null;
};

const dispatchEvent = (detail) => {
    const { type = 'info', position, button, dismissEvent, duration, title, description, html, icon, ...rest } = detail ?? {};

    const opts = {
        ...(title ? { title } : {}),
        ...(html ? { description: React.createElement('span', { dangerouslySetInnerHTML: { __html: html } }) } : description ? { description } : {}),
        ...(duration !== undefined ? { duration } : {}),
        ...(position ? { position } : {}),
        ...(icon ? { icon: renderIcon(icon) } : {}),
        ...rest,
    };

    if (button) {
        opts.button = {
            title: button.title,
            onClick: button.onClick ?? (() => Livewire.dispatch(button.event, button.params ?? {})),
        };
    }

    if (dismissEvent) {
        opts.onDismiss = () => Livewire.dispatch(dismissEvent.event, dismissEvent.params ?? {});
    }

    const methods = {
        success: () => sileo.success(opts),
        error: () => sileo.error(opts),
        warning: () => sileo.warning(opts),
        info: () => sileo.info(opts),
        loading: () => sileo.show({ ...opts, state: 'loading' }),
        action: () => sileo.action(opts),
    };

    (methods[type] || methods.info)();
};

window.addEventListener('sileo', ({ detail }) => {
    const payload = Array.isArray(detail) ? detail[0] : detail;
    dispatchEvent(payload);
});

window.addEventListener('sileo.promise', ({ detail }) => {
    const data = Array.isArray(detail) ? detail[0] : detail;
    const {
        event,
        loading = { title: 'Loading…' },
        success = { title: 'Done!' },
        error = { title: 'Failed.' },
        position,
    } = data ?? {};

    if (!event) {
        return;
    }

    const resolveEvent = `sileo.resolve.${event}`;
    const rejectEvent = `sileo.reject.${event}`;

    const normalize = (value) => {
        if (typeof value === 'string') {
            return { title: value };
        }
        if (value?.icon) {
            return { ...value, icon: renderIcon(value.icon) };
        }
        if (value?.html) {
            return { ...value, description: React.createElement('span', { dangerouslySetInnerHTML: { __html: value.html } }) };
        }
        return value;
    };

    const promise = new Promise((resolve, reject) => {
        window.addEventListener(resolveEvent, resolve, { once: true });
        window.addEventListener(rejectEvent, reject, { once: true });

        Livewire.dispatch(event);
    });

    sileo.promise(promise, {
        loading: normalize(loading),
        success: normalize(success),
        error: normalize(error),
        position,
    });
});
