import React, { createContext, useState, useContext, ReactNode } from 'react'
import CloseIcon from '@mui/icons-material/Close';
import { Z_INDEX_MODAL_WRAPPER } from './zIndex'

const ModalContext = createContext({
	modal: <></>,
	openModal: ({}: {
		title: string,
		className: string,
		content: ReactNode,
		closeCallback?: () => void | null,
		isCleanUp?: boolean,
	}) => { console.log('origin') },
	closeModal: () => {},
	setPreventClose: (s: string) => {}
});


const ModalContextProvider: React.VFC<{children: ReactNode}> = ({ children }) =>
{
	const [ modal, setModal ] = useState(null)
	const [ isCleanUp, setIsCleanUp ] = useState(false)
	const [ preventClose, setPreventClose ] = useState<string|null>(null)

	const cleanUp = (e) =>
	{
		if (isCleanUp) setModal(null)
	}
	window.addEventListener('popstate', cleanUp)
	document.addEventListener('inertia:before', cleanUp)

	const openModal = ({
		content,
		title = '',
		className = '',
		closeCallback = null,
		preventCloseCallback = null,
		isCleanUp = true,
	}) =>
	{
		setIsCleanUp(isCleanUp)
		setPreventClose(null)
		setModal({
			content: content,
			title: title,
			className: className,
			closeCallback: closeCallback,
		});
	}

	const closeModal = () =>
	{
		if (modal && 'closeCallback' in modal && modal.closeCallback && typeof modal.closeCallback === 'function')
		{
			modal.closeCallback()
		}

		if (modal && preventClose)
		{
            if (!confirm(preventClose)) return
		}

		setModal(null)
	}

	return (
		<ModalContext.Provider
			value={{
				modal,
				openModal,
				closeModal,
				setPreventClose: (s) => setPreventClose(s)
			}}
		>
			{ children }


			{modal && (<div className='Modal'
                style={{ position: 'fixed', zIndex: Z_INDEX_MODAL_WRAPPER, top: 0, left: 0, width: '100vw', height: '100vh'}}
				onClick={closeModal}
			>
				<div
					className={`ModalMain ${modal.className ?? ''}`}
					onClick={(e) => e.stopPropagation()}
				>
					<header>
						<h1>{modal.title ?? ''}</h1>
						<button className="button close" onClick={closeModal}><CloseIcon /></button>
					</header>
					<div className="ModalContent">
						{modal.content ?? ''}
					</div>
				</div>
			</div>)}

		</ModalContext.Provider>
	);
};


const useModalContext = () => useContext(ModalContext);


export {
	ModalContextProvider,
	useModalContext,
}
