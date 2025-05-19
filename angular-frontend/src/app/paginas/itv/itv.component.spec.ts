import { ComponentFixture, TestBed } from '@angular/core/testing';

import { ItvComponent } from './itv.component';

describe('ItvComponent', () => {
  let component: ItvComponent;
  let fixture: ComponentFixture<ItvComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [ItvComponent]
    })
    .compileComponents();

    fixture = TestBed.createComponent(ItvComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
