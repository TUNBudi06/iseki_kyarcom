export type TractorKyarcom = {
    name: string;
    value: string[] | number;
    type: 'tractor' | 'other';
};

export type Tractor = {
    no: string;
    name: string;
    color: string;
};

export type KyarcomInterface = {
    date: string;
    name: string;
    tractor_used: Tractor[];
    tractor_notused: Tractor[];
};
